<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    // protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationIcon = 'heroicon-o-tag';

public static function canCreate(): bool
{
    return auth()->user()->role !== 'author';
}

public static function canEdit($record = null): bool
{
    return auth()->user()->role !== 'author';
}

public static function canDelete($record = null): bool
{
    return auth()->user()->role !== 'author';
}

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('name')->required()->maxLength(100),
            TextInput::make('slug')->required()->maxLength(100),
        ]);
    }

    public static function table(Table $table): Table
    {
            return $table
        ->columns([
            TextColumn::make('name')->sortable()->searchable(),
            TextColumn::make('slug')->sortable(),
            TextColumn::make('created_at')->dateTime(),
        ])
        ->actions([
            EditAction::make(),
        ])
        ->bulkActions([
            DeleteBulkAction::make(),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }    

    // public static function canCreate(): bool
    // {
    //     return auth()->user()->role !== 'author';
    // }

    // public static function canEdit($record = null): bool
    // {
    //     return auth()->user()->role !== 'author';
    // }

    // public static function canDelete($record = null): bool
    // {
    //     return auth()->user()->role !== 'author';
    // }

}
