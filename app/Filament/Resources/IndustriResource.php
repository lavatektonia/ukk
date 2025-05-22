<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IndustriResource\Pages;
use App\Filament\Resources\IndustriResource\RelationManagers;
use App\Models\Industri;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IndustriResource extends Resource
{
    protected static ?string $model = Industri::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2) //form dibagi 2 kolom
                    ->schema([
                        //foto
                        Forms\Components\FileUpload::make('foto')
                            ->label('Logo Industri')
                            ->image()
                            ->directory('industri')
                            ->columnspan(2)
                            ->required(),
                        
                        //nama
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama')
                            ->placeholder('Nama Industri')
                            ->columnSpan(2)
                            ->required(),

                        //bidang usaha
                        Forms\Components\TextInput::make('bidang_usaha')
                            ->label('Bidang Usaha')
                            ->placeholder('Bidang Usaha')
                            ->required(),

                        //website
                        Forms\Components\TextInput::make('website')
                            ->label('Website')
                            ->placeholder('Website Industri')
                            ->url() //harus berupa url
                            ->required(),
                        
                        //email
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->placeholder('Email Industri')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'Email ini sudah terdaftar',
                            ])
                            ->required(),

                        //kontak
                        Forms\Components\TextInput::make('kontak')
                            ->label('Kontak')
                            ->placeholder('Kontak Industri')
                            ->required(),

                        //alamat
                        Forms\Components\TextInput::make('alamat')
                            ->label('Alamat')
                            ->placeholder('Alamat Industri')
                            ->columnspan(2)
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //nomor urut dari terkecil ke terbesar
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->getStateUsing(fn ($record) => industri::orderBy('id')->pluck('id')
                    ->search($record->id) + 1),
                
                //foto
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Logo'),
                
                //nama
                Tables\Columns\ImageColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                
                //bidang usaha
                Tables\Columns\TextColumn::make('bidang_usaha')
                    ->label('Bidang Usaha')
                    ->searchable()
                    ->sortable(),

                //website
                Tables\Columns\TextColumn::make('website')
                    ->label('Website')
                    ->searchable()
                    ->sortable(),

                //email
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                //kontak
                Tables\Columns\TextColumn::make('kontak')
                    ->label('Kontak')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                ]),
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
            'index' => Pages\ListIndustris::route('/'),
            'create' => Pages\CreateIndustri::route('/create'),
            'view' => Pages\ViewIndustri::route('/{record}'),
            'edit' => Pages\EditIndustri::route('/{record}/edit'),
        ];
    }
}
