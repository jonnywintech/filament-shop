<?php

namespace App\Filament\Clusters\Pages;

use App\Enums\Font;
use Filament\Forms\Form;
use Filament\Pages\Page;
use App\Enums\PrimaryColor;
use Livewire\Attributes\On;
use Filament\Actions\Action;
use App\Enums\RecordsPerPage;
use App\Events\ShopConfigured;
use Livewire\Attributes\Locked;
use App\Listeners\ConfigureShop;
use function Filament\authorize;
use App\Enums\TableSortDirection;
use Filament\Actions\ActionGroup;
use App\Filament\Clusters\Settings;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Support\Exceptions\Halt;
use Filament\Forms\Components\Section;
use App\Models\Invoice as InvoiceModel;
use Filament\Forms\Components\Checkbox;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\Component;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;

use Filament\Forms\Components\ColorPicker;
use Illuminate\Contracts\Support\Htmlable;
use App\Models\Appearance as AppearanceModel;
use Illuminate\Auth\Access\AuthorizationException;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

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

    #[Locked]
    public ?InvoiceModel $record = null;


    public function logo(): mixed
    {
        return current($this->data['logo']) ?? '';
    }

    public function showLogo(): bool
    {
        return $this->data['show_logo'] ?? false;
    }
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

        // dd($this->record);
        abort_unless(static::canView($this->record), 404);

        $this->fillForm();
    }

    public function fillForm(): void
    {
        $data = $this->record->attributesToArray();

        $this->form->fill($data);

        $this->data['font'] = $data['font'] ?? Font::DEFAULT;
        $this->data['color'] = $data['color'] ?? PrimaryColor::DEFAULT;
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();
            $user = auth()->user();
            $appearance = $this->record;
            $data['user_id'] = $user->id;

            $this->handleRecordUpdate($this->record, $data);
            $this->dispatch('update-font');

            // ShopConfigured::dispatch($appearance);
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
            ])
            ->model($this->record)
            ->statePath('data')
            ->operation('edit');
    }

    protected function getGeneralSection(): Component
    {
        return Section::make('General')
            ->schema([
                ColorPicker::make('color')->label('Pick Accent color'),
                Select::make('font')
                    ->allowHtml()
                    ->native(false)
                    ->options(
                        collect(Font::cases())
                            ->mapWithKeys(static fn ($case) => [
                                $case->value => "<span style='font-family:{$case->getLabel()}'>{$case->getLabel()}</span>",
                            ]),
                    ),
                FileUpload::make('logo')
                    ->openable()
                    ->maxSize(1024)
                    ->visibility('public')
                    ->disk('public')
                    ->directory('logos/document')
                    ->imageResizeMode('contain')
                    ->imageCropAspectRatio('3:2')
                    ->panelAspectRatio('3:2')
                    ->panelLayout('integrated')
                    ->removeUploadedFileButtonPosition('center bottom')
                    ->uploadButtonPosition('center bottom')
                    ->uploadProgressIndicatorPosition('center bottom')
                    ->getUploadedFileNameForStorageUsing(
                        static fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                            ->prepend(auth()->user()->id . '_'),
                    )
                    ->extraAttributes([
                        'class' => 'aspect-[3/2] w-[9.375rem] max-w-full',
                    ])
                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/gif']),
                Checkbox::make('show_logo')
                    ->live(),
            ])->columns();
    }

    protected function handleRecordUpdate(InvoiceModel $record, array $data): InvoiceModel
    {
        $record->fill($data);

        $keysToWatch = [
            'primary_color',
            'font',
        ];

        if ($record->isDirty($keysToWatch)) {
            // $this->dispatch('appearanceUpdated');
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
