<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuruResource\Pages;
use App\Filament\Resources\GuruResource\RelationManagers;
use App\Models\Guru;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GuruResource extends Resource
{
    protected static ?string $model = Guru::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                ->schema([
                    //nama
                    Forms\Components\TextInput::make('nama')
                        ->label('Nama')
                        ->placeholder('Nama Guru')
                        ->required(),
                    
                    //nip
                    Forms\Components\TextInput::make('nip')
                        ->label('NIP')
                        ->placeholder('NIP Guru')
                        ->unique(ignoreRecord: true)
                        ->validationMessages([
                            'unique' => 'NIP ini sudah terdaftar',
                        ])
                        ->required(),
                    
                    //gender
                    Forms\Components\Select::make('gender')
                        ->label('Jenis Kelamin')
                        ->options([
                            'Laki-laki' => 'Laki-laki',
                            'Perempuan' => 'Perempuan',
                        ])
                        ->native(False)
                        ->columnSpan(2)
                        ->required(),
                    
                    //email
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->placeholder('Email Guru')
                        ->email()
                        ->unique(ignoreRecord: true)
                        ->validationMessages([
                            'unique' => 'Email ini sudah terdaftar',
                        ])
                        ->required(),

                    //kontak
                    Forms\Components\TextInput::make('kontak')
                        ->label('Kontak')
                        ->placeholder('Kontak Guru')
                        ->required(),
                    
                    //alamat
                    Forms\Components\TextInput::make('alamat')
                        ->label('Alamat')
                        ->placeholder('Alamat Guru')
                        ->columnSpan(2)
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //nomor urut dari terkecil ke terbesar
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->getStateUsing(fn ($record) => guru::orderBy('id')->pluck('id')
                    ->search($record->id) + 1),

                //nama
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                
                //gender
                Tables\Columns\TextColumn::make('gender')
                    ->label('Gender')
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
            'index' => Pages\ListGurus::route('/'),
            'create' => Pages\CreateGuru::route('/create'),
            'view' => Pages\ViewGuru::route('/{record}'),
            'edit' => Pages\EditGuru::route('/{record}/edit'),
        ];
    }
}
