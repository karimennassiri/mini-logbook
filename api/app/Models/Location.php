<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Propaganistas\LaravelPhone\PhoneNumber;
use App\Http\Enums\LocationStatusEnum;
use BenSampo\Enum\Rules\EnumValue;

class Location extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'status',
        'description',
        'phoneNumber',
        'countryCode'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
    */
    protected $casts = [
        'status' => 'string',
        'description' => 'string',
    ];

    /**
     * Set the validation rules.
     *
     * @return array<string, string>
    */
    public static function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'status' => ['required', new EnumValue(LocationStatusEnum::class)],
            'description' => 'nullable|string',
            'phoneNumber' => 'required|phone:AUTO',
            'countryCode' => 'required|string|size:2'
        ];
    }

    /**
     * Format and Set the the phone number depends on the country code
     *
     * @return void
    */
    public function setPhoneNumberAttribute($value): void
    {   
        // Create the phone number with the formatE164 format
        $phoneNumber = (new PhoneNumber($value,$this->attributes['countryCode'] ?? 'US'))->formatE164();
        // Setting the new phone number to the atrributes array
        $this->attributes['phoneNumber'] = $phoneNumber;
    }

    /**
     * Getting the formated phone number
     *
     * @return string
    */    
    public function getPhoneNumberAttribute($value): string
    {
        return $value;
    }
}
