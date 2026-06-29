<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // bisa ganti Imagick kalau ekstensi aktif
use Illuminate\Support\Facades\Storage;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Product Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Placeholder::make('uploaded_by_name')
                    ->label('Nama Admin Pengunggah')
                    ->content(fn($record) => $record?->user?->name)
                    ->visible(fn() => auth()->user()?->role === 'super-admin'),

                Placeholder::make('uploaded_by_email')
                    ->label('Email Admin Pengunggah')
                    ->content(fn($record) => $record?->user?->email)
                    ->visible(fn() => auth()->user()?->role === 'super-admin'),

                FileUpload::make('image')
                    ->label('Gambar Produk')
                    ->image()
                    ->disk('public')
                    ->directory('products')
                    ->visibility('public')
                    ->maxSize(4096)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->imageEditor()
                    ->imageCropAspectRatio('1:1')
                    ->imagePreviewHeight('200')
                    ->saveUploadedFileUsing(function (TemporaryUploadedFile $file): string {
                        // Buat ImageManager dengan driver GD
                        $manager = new ImageManager(new Driver());

                        // Baca file gambar
                        $img = $manager->read($file->getRealPath());

                        // Resize aman max 800px
                        $img->resize(800, null, function ($c) {
                            $c->aspectRatio();
                            $c->upsize();
                        });

                        // Simpan ke public/products
                        $uuid = (string) str()->uuid();
                        try {
                            $path = "products/{$uuid}.webp";
                            Storage::disk('public')->put($path, (string) $img->toWebp(80));
                        } catch (\Throwable $e) {
                            $path = "products/{$uuid}.jpg";
                            Storage::disk('public')->put($path, (string) $img->toJpeg(75));
                        }

                        return $path;
                    })
                    ->hint('Gambar otomatis di-resize max 800px & dikompresi')
                    ->nullable(),

                TextInput::make('product_name')
                    ->label('Nama Produk')
                    ->required()
                    ->maxLength(255),

                TextInput::make('sku')
                    ->label('SKU')
                    ->disabled()
                    ->dehydrated(false)
                    ->visibleOn('edit', 'view')
                    ->nullable(),

                TextInput::make('price')
                    ->label('Harga')
                    ->required()
                    ->numeric()
                    ->minValue(0),

                TextInput::make('stock')
                    ->label('Stok')
                    ->required()
                    ->numeric()
                    ->minValue(0),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'available' => 'Available',
                        'out_of_stock' => 'Out of Stock',
                    ])
                    ->default('available')
                    ->required(),

                TextInput::make('brand')
                    ->label('Brand')
                    ->nullable()
                    ->maxLength(100),

                TextInput::make('color')
                    ->label('Color')
                    ->nullable()
                    ->maxLength(50),

                TextInput::make('size')
                    ->label('Size')
                    ->nullable()
                    ->maxLength(50),

                TextInput::make('weight')
                    ->label('Weight (kg)')
                    ->numeric()
                    ->nullable(),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->maxLength(65535),

                Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'category_name')
                    ->required(),
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
                    ->height(50),

                TextColumn::make('product_name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('sku')
                    ->label('SKU')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('Diunggah Oleh')
                    ->sortable()
                    ->searchable()
                    ->visible(fn() => auth()->user()?->role === 'super-admin'),

                TextColumn::make('user.email')
                    ->label('Email Admin')
                    ->sortable()
                    ->searchable()
                    ->visible(fn() => auth()->user()?->role === 'super-admin'),

                TextColumn::make('category.category_name')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Harga')
                    ->money('idr', true)
                    ->alignEnd()
                    ->sortable()
                    ->visible(fn() => auth()->user()?->role !== 'super-admin'),

                TextColumn::make('stock')
                    ->label('Stok')
                    ->sortable()
                    ->visible(fn() => auth()->user()?->role !== 'super-admin'),

                TextColumn::make('brand')
                    ->label('Brand')
                    ->sortable()
                    ->searchable()
                    ->visible(fn() => auth()->user()?->role !== 'super-admin'),

                TextColumn::make('color')
                    ->label('Warna')
                    ->sortable()
                    ->searchable()
                    ->visible(fn() => auth()->user()?->role !== 'super-admin'),

                TextColumn::make('size')
                    ->label('Ukuran')
                    ->sortable()
                    ->searchable()
                    ->visible(fn() => auth()->user()?->role !== 'super-admin'),

                TextColumn::make('weight')
                    ->label('Berat (kg)')
                    ->sortable()
                    ->visible(fn() => auth()->user()?->role !== 'super-admin'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'available' => 'success',
                        'out_of_stock' => 'danger',
                    ])
                    ->sortable()
                    ->visible(fn() => auth()->user()?->role !== 'super-admin'),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y - H:i'),
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
            ])
            ->searchable();
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()?->role === 'admin') {
            $query->where('user_id', auth()->id());
        }

        return $query;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
