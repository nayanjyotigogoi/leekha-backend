<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReadersWallResource\Pages;
use App\Filament\Resources\ReadersWallResource\RelationManagers;
use App\Models\ReadersWall;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;



use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ColorPicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;

class ReadersWallResource extends Resource
{
    protected static ?string $model = ReadersWall::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('text')
                    ->required()
                    ->maxLength(280)
                    ->label('Message'),
                ColorPicker::make('color')
                    ->required()
                    ->label('Background Color'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('text')->limit(50),
                TextColumn::make('color')
                    ->color(fn ($record) => $record->color)
                    ->label('Background Color'),
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
            'index' => Pages\ListReadersWalls::route('/'),
            'create' => Pages\CreateReadersWall::route('/create'),
            'edit' => Pages\EditReadersWall::route('/{record}/edit'),
        ];
    }  
    
   // Access restrictions
    public static function canViewAny(): bool { return auth()->user()->role === 'super_admin'; }
    public static function canCreate(): bool { return auth()->user()->role === 'super_admin'; }
    public static function canEdit($record = null): bool { return auth()->user()->role === 'super_admin'; }
    public static function canDelete($record = null): bool { return auth()->user()->role === 'super_admin'; }
    public static function canDeleteAny(): bool { return auth()->user()->role === 'super_admin'; }


}
