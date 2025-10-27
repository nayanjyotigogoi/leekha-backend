<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaResource\Pages;
use App\Models\Media;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Resources\Form;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;
    protected static ?string $navigationIcon = 'heroicon-o-photograph';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        if (auth()->user()->role === 'author') {
            $query->where('author_id', auth()->id());
        }
        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('type')
                ->options([
                    'image' => 'Image',
                    'sound' => 'Sound',
                    'sticker' => 'Sticker',
                ])
                ->required(),
            FileUpload::make('path')->directory('media')->required(),
            TextInput::make('alt_text')->maxLength(255),
            TextInput::make('metadata')->placeholder('{"width":800,"height":600}'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('type')->sortable(),
            TextColumn::make('path')->limit(50),
            TextColumn::make('alt_text')->limit(50),
            TextColumn::make('created_at')->dateTime(),
        ])
        ->actions([EditAction::make()])
        ->bulkActions([DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMedia::route('/'),
            'create' => Pages\CreateMedia::route('/create'),
            'edit' => Pages\EditMedia::route('/{record}/edit'),
        ];
    }
}
