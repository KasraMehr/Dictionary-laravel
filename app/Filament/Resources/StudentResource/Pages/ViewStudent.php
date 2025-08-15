<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables;
use Filament\Tables\Table;

class ViewStudent extends ViewRecord
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('ویرایش دانش آموز'),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Tabs::make('جزئیات دانش آموز')
                ->tabs([
                    Tabs\Tab::make('اطلاعات اصلی')
                        ->schema([
                            Section::make('اطلاعات حساب کاربری')
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->label('نام کامل')
                                        ->required()
                                        ->disabled(),
                                    Forms\Components\TextInput::make('email')
                                        ->label('ایمیل')
                                        ->email()
                                        ->required()
                                        ->disabled(),
                                ])->columns(2),
                        ]),

                    Tabs\Tab::make('پروفایل دانش آموزی')
                        ->schema([
                            Section::make('')
                                ->relationship('studentProfile')
                                ->schema([
                                    Forms\Components\Textarea::make('bio')
                                        ->label('بیوگرافی')
                                        ->disabled()
                                        ->columnSpanFull(),

                                    Forms\Components\TextInput::make('phone')
                                        ->label('تلفن')
                                        ->disabled(),

                                    Forms\Components\DatePicker::make('birth_date')
                                        ->label('تاریخ تولد')
                                        ->disabled(),

                                    Forms\Components\Select::make('education_level')
                                        ->label('سطح تحصیلات')
                                        ->disabled()
                                        ->options([
                                            'primary' => 'ابتدایی',
                                            'secondary' => 'متوسطه',
                                            'bachelor' => 'لیسانس',
                                            'master' => 'فوق لیسانس',
                                            'phd' => 'دکترا',
                                        ]),
                                ])->columns(2),
                        ]),

                    Tabs\Tab::make('آمار یادگیری')
                        ->schema([
                            Section::make('')
                                ->relationship('learningStat')
                                ->schema([
                                    Forms\Components\TextInput::make('learned_words_count')
                                        ->label('تعداد کلمات یادگرفته شده')
                                        ->disabled(),

                                    Forms\Components\TextInput::make('active_days_streak')
                                        ->label('روزهای فعال متوالی')
                                        ->disabled(),

                                    Forms\Components\TextInput::make('total_study_minutes')
                                        ->label('مدت مطالعه (دقیقه)')
                                        ->disabled(),

                                    Forms\Components\TextInput::make('rank')
                                        ->label('رتبه')
                                        ->disabled(),
                                ])->columns(2),
                        ]),
                ]),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان'),

                Tables\Columns\TextColumn::make('pivot.progress')
                    ->label('پیشرفت')
                    ->suffix('%'),

                Tables\Columns\TextColumn::make('pivot.enrolled_at')
                    ->label('تاریخ ثبت نام')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->makeForm()
                ->schema($this->getFormSchema())
                ->model($this->getRecord())
                ->statePath('data')
                ->disabled(),
        ];
    }
}
