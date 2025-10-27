<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WritingResource\Pages;
use App\Models\Writing;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Resources\Form;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;

class WritingResource extends Resource
{
    protected static ?string $model = Writing::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

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
            TextInput::make('title')->required(),
            Select::make('author_id')
                ->relationship('author', 'name')
                ->default(auth()->id())
                ->disabled(fn () => auth()->user()->role === 'author')
                ->required(),
            Select::make('category')
                ->options([
                    'Poem' => 'Poem',
                    'Story' => 'Story',
                    'Note' => 'Note',
                ])->required(),
            TextInput::make('preview')->required(),
            TextInput::make('reading_time')->numeric(),
            FileUpload::make('media')->directory('media'),
            RichEditor::make('content')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('title')->sortable()->searchable(),
            TextColumn::make('author.name')->label('Author'),
            TextColumn::make('category'),
            TextColumn::make('likes_count')->sortable(),
            TextColumn::make('created_at')->dateTime(),
        ])
        ->actions([EditAction::make()])
        ->bulkActions([DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWritings::route('/'),
            'create' => Pages\CreateWriting::route('/create'),
            'edit' => Pages\EditWriting::route('/{record}/edit'),
        ];
    }
}
