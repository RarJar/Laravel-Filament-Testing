<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ColorPicker;
use Filament\Tables\Columns\CheckboxColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class BlogsRelationManager extends RelationManager
{
    protected static string $relationship = 'blogs';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->description("create blog over here ...")->schema([
                FileUpload::make('image')->required(),
                TextInput::make("title")->rules('max:100|min:3')->required(),
                TextInput::make("slug")->unique(ignoreRecord: true)->rules(['alpha_dash'])->required(),
                ColorPicker::make('color')->required(),
                RichEditor::make('content')->required(),
                TagsInput::make('tags')->nullable()->required(),
                Checkbox::make('published')
                ])->columns(1)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                ImageColumn::make("image")->toggleable(),
                TextColumn::make("title")->sortable()->searchable()->toggleable(),
                TextColumn::make("category.name")->sortable()->searchable()->toggleable(),
                ColorColumn::make("color")->toggleable(),
                TextColumn::make("tags")->sortable()->searchable()->toggleable(),
                CheckboxColumn::make('published')->toggleable(),
                TextColumn::make("created_at")->label('Published on')->date()->sortable()->toggleable()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
