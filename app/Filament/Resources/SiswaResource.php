<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Filament\Resources\SiswaResource\RelationManagers;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        //foto
                        Forms\Components\FileUpload::make('foto')
                            ->label('Foto Siswa')
                            ->image()
                            ->directory('siswa')
                            ->columnSpan(2),

                        //nama
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama')
                            ->placeholder('Nama Siswa')
                            ->required(),
                        
                        //nis
                        Forms\Components\TextInput::make('nis')
                            ->label('NIS')
                            ->placeholder('NIS Siswa')
                            ->unique(ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'NIS ini sudah terdaftar',
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
                            ->required(),
                        
                        //rombel
                        Forms\Components\Select::make('rombel')
                            ->label('Rombongan Belajar')
                            ->options([
                                'SIJA A' => 'SIJA A',
                                'SIJA B' => 'SIJA B',
                            ])
                            ->native(False)
                            ->required(),
                        
                        //email
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->placeholder('Email Siswa')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'Email ini sudah terdaftar',
                            ])
                            ->required(),
                        
                        //kontak
                        Forms\Components\TextInput::make('kontak')
                            ->label('Kontak')
                            ->placeholder('Kontak Siswa')
                            ->required(),
                        
                        //alamat
                        Forms\Components\TextInput::make('alamat')
                            ->label('Alamat')
                            ->placeholder('Alamat Siswa')
                            ->columnSpan(2)
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
                    ->getStateUsing(fn ($record) => siswa::orderBy('id')->pluck('id')
                    ->search($record->id) + 1),
                
                //foto
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto'),        

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

                //rombel
                Tables\Columns\TextColumn::make('rombel')
                    ->label('Rombel')
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
                
                //status PKL
                Tables\Columns\BadgeColumn::make('status_lapor_pkl')
                    ->label('Status PKL')
                    ->formatStateUsing(fn ($state) => $state ? 'Aktif' : 'Tidak Aktif') //ubah nilai boolean jadi teks
                    ->color(fn ($state) => $state ? 'success' : 'danger'), //memberi warna badge, success jika aktif, danger jika inactive
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gender')
                    ->label('Gender')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ]),
                Tables\Filters\SelectFilter::make('rombel')
                    ->label('Rombongan Belajar')
                    ->options([
                        'SIJA A' => 'SIJA A',
                        'SIJA B' => 'SIJA B',
                    ]),
                Tables\Filters\TernaryFilter::make('status_lapor_pkl')
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif'),
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
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'view' => Pages\ViewSiswa::route('/{record}'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}
