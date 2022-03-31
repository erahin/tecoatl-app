<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'El :attribute debe ser aceptado.',
    'accepted_if' => 'El :attribute debe aceptarse cuando: Otro es: value.',
    'active_url' => 'El :attribute no es una URL válida.',
    'after' => 'El :attribute  debe ser una fecha después de :date.',
    'after_or_equal' => 'El :attribute debe ser una fecha después o igual a :date.',
    'alpha' => 'El :attribute solo debe contener letras.',
    'alpha_dash' => 'El :attribute  solo debe contener letras, números, guiones y guiones bajos.',
    'alpha_num' => 'El :attribute solo debe contener letras y números.',
    'array' => 'El :attribute debe ser una matriz.',
    'before' => 'El :attribute debe ser una fecha antes :date.',
    'before_or_equal' => 'El :attribute debe ser una fecha antes o igual a :date.',
    'between' => [
        'numeric' => 'El :attribute debe ser entre :min and :max.',
        'file' => 'El :attribute debe estar entre :min y :max kilobytes.',
        'string' => 'El :attribute debe estar entre :min y :max caracteres.',
        'array' => 'El :attribute debe tener entre :min y :max máximos.',
    ],
    'boolean' => 'El :attribute field must be true or false.',
    'confirmed' => 'El :attribute confirmation does not match.',
    'current_password' => 'El password is incorrect.',
    'date' => 'El :attribute is not a valid date.',
    'date_equals' => 'El :attribute must be a date equal to :date.',
    'date_format' => 'El :attribute does not match the format :format.',
    'declined' => 'El :attribute must be declined.',
    'declined_if' => 'El :attribute must be declined when :other is :value.',
    'different' => 'El :attribute and :other must be different.',
    'digits' => 'El :attribute must be :digits digits.',
    'digits_between' => 'El :attribute must be between :min and :max digits.',
    'dimensions' => 'El :attribute has invalid image dimensions.',
    'distinct' => 'El :attribute field has a duplicate value.',
    'email' => 'El :attribute must be a valid email address.',
    'ends_with' => 'El :attribute must end with one of the following: :values.',
    'enum' => 'El selected :attribute is invalid.',
    'exists' => 'El selected :attribute is invalid.',
    'file' => 'El :attribute must be a file.',
    'filled' => 'El :attribute field must have a value.',
    'gt' => [
        'numeric' => 'El :attribute must be greater than :value.',
        'file' => 'El :attribute must be greater than :value kilobytes.',
        'string' => 'El :attribute must be greater than :value characters.',
        'array' => 'El :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'El :attribute must be greater than or equal to :value.',
        'file' => 'El :attribute must be greater than or equal to :value kilobytes.',
        'string' => 'El :attribute must be greater than or equal to :value characters.',
        'array' => 'El :attribute must have :value items or more.',
    ],
    'image' => 'El :attribute must be an image.',
    'in' => 'El selected :attribute is invalid.',
    'in_array' => 'El :attribute field does not exist in :other.',
    'integer' => 'El :attribute must be an integer.',
    'ip' => 'El :attribute must be a valid IP address.',
    'ipv4' => 'El :attribute must be a valid IPv4 address.',
    'ipv6' => 'El :attribute must be a valid IPv6 address.',
    'json' => 'El :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'El :attribute must be less than :value.',
        'file' => 'El :attribute must be less than :value kilobytes.',
        'string' => 'El :attribute must be less than :value characters.',
        'array' => 'El :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'El :attribute must be less than or equal to :value.',
        'file' => 'El :attribute must be less than or equal to :value kilobytes.',
        'string' => 'El :attribute must be less than or equal to :value characters.',
        'array' => 'El :attribute must not have more than :value items.',
    ],
    'mac_address' => 'El :attribute must be a valid MAC address.',
    'max' => [
        'numeric' => 'El :attribute must not be greater than :max.',
        'file' => 'El :attribute must not be greater than :max kilobytes.',
        'string' => 'El :attribute must not be greater than :max characters.',
        'array' => 'El :attribute must not have more than :max items.',
    ],
    'mimes' => 'El :attribute must be a file of type: :values.',
    'mimetypes' => 'El :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'El :attribute must be at least :min.',
        'file' => 'El :attribute must be at least :min kilobytes.',
        'string' => 'El :attribute must be at least :min characters.',
        'array' => 'El :attribute must have at least :min items.',
    ],
    'multiple_of' => 'El :attribute must be a multiple of :value.',
    'not_in' => 'El selected :attribute is invalid.',
    'not_regex' => 'El :attribute format is invalid.',
    'numeric' => 'El :attribute must be a number.',
    'password' => 'El password is incorrect.',
    'present' => 'El :attribute field must be present.',
    'prohibited' => 'El :attribute field is prohibited.',
    'prohibited_if' => 'El :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'El :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'El :attribute field prohibits :other from being present.',
    'regex' => 'El :attribute format is invalid.',
    'required' => 'El :attribute field is required.',
    'required_array_keys' => 'El :attribute field must contain entries for: :values.',
    'required_if' => 'El :attribute field is required when :other is :value.',
    'required_unless' => 'El :attribute field is required unless :other is in :values.',
    'required_with' => 'El :attribute field is required when :values is present.',
    'required_with_all' => 'El :attribute field is required when :values are present.',
    'required_without' => 'El :attribute field is required when :values is not present.',
    'required_without_all' => 'El :attribute field is required when none of :values are present.',
    'same' => 'El :attribute and :other must match.',
    'size' => [
        'numeric' => 'El :attribute must be :size.',
        'file' => 'El :attribute must be :size kilobytes.',
        'string' => 'El :attribute must be :size characters.',
        'array' => 'El :attribute must contain :size items.',
    ],
    'starts_with' => 'El :attribute must start with one of the following: :values.',
    'string' => 'El :attribute must be a string.',
    'timezone' => 'El :attribute must be a valid timezone.',
    'unique' => 'El :attribute has already been taken.',
    'uploaded' => 'El :attribute failed to upload.',
    'url' => 'El :attribute must be a valid URL.',
    'uuid' => 'El :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
