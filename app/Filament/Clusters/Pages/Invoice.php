<?php

namespace App\Filament\Clusters\Pages;

use App\Enums\Font;
use App\Enums\PrimaryColor;
use App\Enums\RecordsPerPage;
use App\Enums\TableSortDirection;
use App\Events\ShopConfigured;
use App\Filament\Clusters\Settings;
use App\Listeners\ConfigureShop;
use App\Models\Appearance as AppearanceModel;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Filament\Support\Enums\MaxWidth;
use Filament\Support\Exceptions\Halt;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Locked;
use App\Models\Invoice as InvoiceModel;

use function Filament\authorize;

/**
 * @property Form $form
 */
class Invoice extends Page
{
    use InteractsWithFormActions;

    protected static ?string $title = 'Invoice';

    protected static string $view = 'filament.clusters.pages.invoice';

    protected static ?string $cluster = Settings::class;

    public ?array $data = [];

    // #[Locked]
    public ?InvoiceModel $record = null;

    public function getTitle(): string | Htmlable
    {
        return static::$title;
    }

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::ScreenTwoExtraLarge;
    }

    public static function getNavigationLabel(): string
    {
        return static::$title;
    }

    public function mount(): void
    {
        $this->record = InvoiceModel::firstOrNew([
            'user_id' => auth()->user()->id,
        ]);

        abort_unless(static::canView($this->record), 404);

        $this->fillForm();
    }

    public function fillForm(): void
    {
        $data = $this->record->attributesToArray();

        $this->form->fill($data);
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();
            $user = auth()->user();
            $appearance = $this->record;
            $data['user_id'] = $user->id;

            $this->handleRecordUpdate($this->record, $data);

            ShopConfigured::dispatch($appearance);
        } catch (Halt $exception) {
            return;
        }

        $this->getSavedNotification()->send();
    }

    protected function getSavedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getGeneralSection(),
                $this->getDataPresentationSection(),
            ])
            ->model($this->record)
            ->statePath('data')
            ->operation('edit');
    }

    protected function getGeneralSection(): Component
    {
        return Section::make('General')
            ->schema([
                Select::make('primary_color')
                    ->allowHtml()
                    ->native(false)
                    ->options(
                        collect(PrimaryColor::cases())
                            ->sort(static fn ($a, $b) => $a->value <=> $b->value)
                            ->mapWithKeys(static fn ($case) => [
                                $case->value => "<span class='flex items-center gap-x-4'>
                                <span class='rounded-full w-4 h-4' style='background:rgb(" . $case->getColor()[600] . ")'></span>
                                <span>" . $case->getLabel() . '</span>
                                </span>',
                            ]),
                    ),
                Select::make('font')
                    ->allowHtml()
                    ->native(false)
                    ->options(
                        collect(Font::cases())
                            ->mapWithKeys(static fn ($case) => [
                                $case->value => "<span style='font-family:{$case->getLabel()}'>{$case->getLabel()}</span>",
                            ]),
                    ),
            ])->columns();
    }

    protected function getDataPresentationSection(): Component
    {
        return Section::make('Data Presentation')
            ->schema([
                Select::make('table_sort_direction')
                    ->options(TableSortDirection::class),
                Select::make('records_per_page')
                    ->options(RecordsPerPage::class),
            ])->columns();
    }

    protected function handleRecordUpdate(AppearanceModel $record, array $data): AppearanceModel
    {
        $record->fill($data);

        $keysToWatch = [
            'primary_color',
            'font',
        ];

        if ($record->isDirty($keysToWatch)) {
            $this->dispatch('appearanceUpdated');
        }

        $record->save();

        return $record;
    }

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
            ->submit('save')
            ->keyBindings(['mod+s']);
    }

    public static function canView(Model $record): bool
    {
        try {
            return authorize('update', $record)->allowed();
        } catch (AuthorizationException $exception) {
            return $exception->toResponse()->allowed();
        }
    }
}
