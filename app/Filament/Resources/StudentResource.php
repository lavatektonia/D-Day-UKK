<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationLabel = 'SIJA Students';
    protected static ?string $pluralLabel = 'List Student';

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->placeholder('Student Name')
                            ->required(),

                        Forms\Components\TextInput::make('nis')
                            ->label('NIS')
                            ->placeholder('Student NIS')
                            ->unique(ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'NIS is already registered',
                            ])
                            ->required(),

                        Forms\Components\Select::make('gender')
                            ->label('Gender')
                            ->options([
                                'M' => 'Male',
                                'F' => 'Female',
                            ])
                            ->native(false)
                            ->required(),

                        Forms\Components\Select::make('class_group')
                            ->label('Class Group')
                            ->options([
                                'SijaA' => 'SIJA A',
                                'SijaB' => 'SIJA B',
                            ])
                            ->native(false)
                            ->required(),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->placeholder('Student Email')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'Email is already registered',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('contact')
                            ->label('Contact')
                            ->placeholder('Student Contact')
                            ->required(),

                        Forms\Components\TextInput::make('address')
                            ->label('Address')
                            ->placeholder('Student Address')
                            ->columnSpan(2)
                            ->required(),

                        // Field Foto
                        Forms\Components\FileUpload::make('photo')
                            ->label('Photo')
                            ->image()
                            ->directory('students/photos')
                            ->maxSize(1024) // max 1MB
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('id')
                //     ->label('ID')
                //     ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nis')
                    ->label('NIS')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('gender')
                    ->label('Gender')
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => $state === 'M' ? 'Male' : 'Female')
                    ->sortable(),

                Tables\Columns\TextColumn::make('class_group')
                    ->label('Class Group')
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => $state === 'SijaA' ? 'SIJA A' : 'SIJA B')
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('contact')
                    ->label('Contact')
                    ->url(fn ($record) => 'https://wa.me/' . preg_replace('/[^0-9]/', '', $record->contact))
                    ->openUrlInNewTab()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('pkl_report_status')
                    ->label('PKL Report Status')
                    ->formatStateUsing(fn ($state) => $state ? 'Aktif' : 'Tidak Aktif')
                    ->color(fn ($state) => $state ? 'success' : 'danger'),

                // Kolom Foto
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Photo')
                    ->rounded()
                    ->size(50),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gender')
                    ->label('Gender')
                    ->options([
                        'M' => 'Male',
                        'F' => 'Female',
                    ]),
                Tables\Filters\SelectFilter::make('class_group')
                    ->label('Class Group')
                    ->options([
                        'SijaA' => 'SIJA A',
                        'SijaB' => 'SIJA B',
                    ]),
                Tables\Filters\TernaryFilter::make('pkl_report_status')
                    ->trueLabel('Active')
                    ->falseLabel('Non-active'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->before(function ($record, $action) {
                            if ($record->pkl_report_status) {
                                \Filament\Notifications\Notification::make()
                                    ->title('Failed to delete')
                                    ->body("Student {$record->name} is still active in PKL.")
                                    ->danger()
                                    ->send();

                                $action->cancel();
                            }
                        }),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->label('Delete Selected')
                    ->before(function ($records, $action) {
                        foreach ($records as $record) {
                            if ($record->pkl_report_status) {
                                \Filament\Notifications\Notification::make()
                                    ->title('Failed to delete')
                                    ->body("Student {$record->name} is still active in PKL.")
                                    ->danger()
                                    ->send();

                                $action->cancel();
                                return;
                            }

                            try {
                                $record->delete();
                            } catch (\Illuminate\Database\QueryException $e) {
                                \Filament\Notifications\Notification::make()
                                    ->title('Failed to delete')
                                    ->body('Student data cannot be deleted because still active in PKL.')
                                    ->danger()
                                    ->send();

                                $action->cancel();
                                return;
                            }
                        }
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'view' => Pages\ViewStudent::route('/{record}'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
