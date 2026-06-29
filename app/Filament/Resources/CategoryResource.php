<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

use Intervention\Image\ImageManager;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;


/**
 * @var \Intervention\Image\Facades\Image $image
 */

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Product Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')
                    ->label('Gambar Kategori')
                    ->image()
                    ->disk('public')
                    ->directory('categories')
                    ->visibility('public')
                    ->maxSize(4096)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->imageEditor()
                    ->imageCropAspectRatio('1:1')
                    ->imagePreviewHeight('200')
                    ->saveUploadedFileUsing(function (TemporaryUploadedFile $file): string {
                        // Buat manager (default pakai GD, bisa juga Imagick kalau diaktifkan)
                        $manager = new ImageManager(new Driver());

                        // Baca file
                        $img = $manager->read($file->getRealPath());

                        // Resize aman: max width 800px
                        $img->resize(800, null, function ($c) {
                            $c->aspectRatio();
                            $c->upsize();
                        });

                        $uuid = (string) str()->uuid();

                        try {
                            $path = "categories/{$uuid}.webp";
                            Storage::disk('public')->put($path, (string) $img->toWebp(80));
                        } catch (\Throwable $e) {
                            $path = "categories/{$uuid}.jpg";
                            Storage::disk('public')->put($path, (string) $img->toJpeg(75));
                        }

                        return $path;
                    })
                    ->hint('Gambar otomatis di-resize max 800px & dikompresi'),

                TextInput::make('category_name')
                    ->label('Nama Kategori')
                    ->required()
                    ->maxLength(255),

                TextInput::make('short_description')
                    ->label('Deskripsi Singkat')
                    ->maxLength(100)
                    ->placeholder('Opsional — maksimal 100 karakter')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('row')
                    ->label('No')
                    ->rowIndex()
                    ->alignCenter(),

                ImageColumn::make('image')
                    ->label('Gambar')
                    ->disk('public')
                    ->width(50)
                    ->height(50)
                    ->circular(),

                TextColumn::make('category_name')
                    ->label('Nama Kategori')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y - H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->role === 'super-admin';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->role === 'super-admin';
    }
}
