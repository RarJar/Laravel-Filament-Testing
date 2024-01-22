<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Blog;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
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
use App\Filament\Resources\BlogResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BlogResource\RelationManagers;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\CheckboxColumn;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rss';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make()->description("create blog over here ...")->collapsible()->schema([
                    FileUpload::make('image')->required(),
                    TextInput::make("title")->rules('max:100|min:3')->required(),
                    TextInput::make("slug")->unique(ignoreRecord: true)->rules(['alpha_dash'])->required(),

                    Select::make("category_id")->label('Category')->options(Category::all()->pluck('name','id'))->searchable()->required(),

                    ColorPicker::make('color')->required(),
                    RichEditor::make('content')->required(),
                    TagsInput::make('tags')->nullable()->required(),
                    Checkbox::make('published')
                ])->columns(1)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
