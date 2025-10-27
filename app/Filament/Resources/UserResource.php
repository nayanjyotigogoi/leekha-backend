<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Resources\Form;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    // protected static ?string $navigationIcon = 'heroicon-o-users';

    // Only super admins can view users
    protected static ?string $navigationIcon = 'heroicon-o-users';

    // Access methods
    public static function canViewAny(): bool { return auth()->user()->role === 'super_admin'; }
    public static function canCreate(): bool { return auth()->user()->role === 'super_admin'; }
    public static function canEdit($record = null): bool { return auth()->user()->role === 'super_admin'; }
    public static function canDelete($record = null): bool { return auth()->user()->role === 'super_admin'; }
    public static function canDeleteAny(): bool { return auth()->user()->role === 'super_admin'; }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(100),
            TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(150),
            TextInput::make('password')
                ->password()
                ->dehydrateStateUsing(fn ($state) => $state ? bcrypt($state) : null)
                ->required(fn ($context) => $context === 'create')
                ->label('Password'),
            Textarea::make('bio')->maxLength(500),
            FileUpload::make('profile_image')->directory('profiles'),
            Select::make('role')
                ->options([
                    'author' => 'Author',
                    'admin' => 'Admin',
                    'super_admin' => 'Super Admin',
                    'visitor' => 'Visitor',
                ])
                ->required(),
            TextInput::make('social_links')
                ->label('Social Links (JSON)')
                ->placeholder('{"twitter":"https://twitter.com/..."}'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->sortable()->searchable(),
            TextColumn::make('email')->sortable()->searchable(),
            TextColumn::make('role'),
            TextColumn::make('created_at')->dateTime(),
        ])
        ->actions([EditAction::make()])
        ->bulkActions([DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
