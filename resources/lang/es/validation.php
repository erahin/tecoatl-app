<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validación del idioma
    |--------------------------------------------------------------------------
    |
    | Las siguientes líneas de idioma contienen los mensajes de error predeterminados utilizados por
    | La clase validadora. Algunas de estas reglas tienen múltiples versiones tales
    | como las reglas de tamaño. Siéntase libre de modificar cada uno de estos mensajes aquí.
    |
    */

    'accepted' => 'El campo campo debe ser aceptado.',
    'accepted_if' => 'El campo campo debe ser aceptado cuando :other es :value.',
    'active_url' => 'El campo campo no es una URL válida.',
    'after' => 'El campo campo debe ser una fecha después de :date.',
    'after_or_equal' => 'El campo campo debe ser una fecha después o igual a :date.',
    'alpha' => 'El campo campo sólo puede contener letras.',
    'alpha_dash' => 'El campo campo sólo puede contener letras, números y guiones.',
    'alpha_num' => 'El campo campo sólo puede contener letras y números.',
    'array' => 'El campo campo debe ser un arreglo.',
    'before' => 'El campo campo debe ser una fecha antes de :date.',
    'before_or_equal' => 'El campo campo debe ser una fecha antes o igual a :date.',
    'between' => [
        'numeric' => 'El campo campo debe estar entre :min - :max.',
        'file' => 'El campo campo debe estar entre :min - :max kilobytes.',
        'string' => 'El campo campo debe estar entre :min - :max caracteres.',
        'array' => 'El campo campo debe tener entre :min y :max elementos.',
    ],
    'boolean' => 'El campo campo debe ser verdadero o falso.',
    'confirmed' => 'El campo de confirmación de campo no coincide.',
    'current_password' => 'La contraseña actual no es correcta',
    'date' => 'El campo campo no es una fecha válida.',
    'date_equals' => 'El campo campo debe ser una fecha igual a :date.',
    'date_format' => 'El campo campo no corresponde con el formato :format.',
    'declined' => 'El campo campo debe marcar como rechazado.',
    'declined_if' => 'El campo campo debe marcar como rechazado cuando :other es :value.',
    'different' => 'Los campos campo y :other deben ser diferentes.',
    'digits' => 'El campo campo debe ser de :digits dígitos.',
    'digits_between' => 'El campo campo debe tener entre :min y :max dígitos.',
    'dimensions' => 'El campo campo no tiene una dimensión válida.',
    'distinct' => 'El campo campo tiene un valor duplicado.',
    'email' => 'El formato del campo no es válido.',
    'ends_with' => 'El campo campo debe terminar con alguno de los valores: :values.',
    'enum' => 'El campo seleccionado en campo no es válido.',
    'exists' => 'El campo campo seleccionado no es válido.',
    'file' => 'El campo campo debe ser un archivo.',
    'filled' => 'El campo campo es requerido.',
    'gt' => [
        'numeric' => 'El campo campo debe ser mayor que :value.',
        'file' => 'El campo campo debe ser mayor que :value kilobytes.',
        'string' => 'El campo campo debe ser mayor que :value caracteres.',
        'array' => 'El campo campo puede tener hasta :value elementos.',
    ],
    'gte' => [
        'numeric' => 'El campo campo debe ser mayor o igual que :value.',
        'file' => 'El campo campo debe ser mayor o igual que :value kilobytes.',
        'string' => 'El campo campo debe ser mayor o igual que :value caracteres.',
        'array' => 'El campo campo puede tener :value elementos o más.',
    ],
    'image' => 'El campo campo debe ser una imagen.',
    'in' => 'El campo campo seleccionado no es válido.',
    'in_array' => 'El campo campo no existe en :other.',
    'integer' => 'El campo campo debe ser un entero.',
    'ip' => 'El campo campo debe ser una dirección IP válida.',
    'ipv4' => 'El campo campo debe ser una dirección IPv4 válida.',
    'ipv6' => 'El campo campo debe ser una dirección IPv6 válida.',
    'json' => 'El campo campo debe ser una cadena JSON válida.',
    'lt' => [
        'numeric' => 'El campo campo debe ser menor que :max.',
        'file' => 'El campo campo debe ser menor que :max kilobytes.',
        'string' => 'El campo campo debe ser menor que :max caracteres.',
        'array' => 'El campo campo puede tener hasta :max elementos.',
    ],
    'lte' => [
        'numeric' => 'El campo campo debe ser menor o igual que :max.',
        'file' => 'El campo campo debe ser menor o igual que :max kilobytes.',
        'string' => 'El campo campo debe ser menor o igual que :max caracteres.',
        'array' => 'El campo campo no puede tener más que :max elementos.',
    ],
    'mac_address' => 'El campo campo debe ser una dirección MAC válida.',
    'max' => [
        'numeric' => 'El campo campo debe ser menor que :max.',
        'file' => 'El campo campo debe ser menor que :max kilobytes.',
        'string' => 'El campo campo debe ser menor que :max caracteres.',
        'array' => 'El campo campo puede tener hasta :max elementos.',
    ],
    'mimes' => 'El campo campo debe ser un archivo de tipo: :values.',
    'mimetypes' => 'El campo campo debe ser un archivo de tipo: :values.',
    'min' => [
        'numeric' => 'El campo campo debe tener al menos :min.',
        'file' => 'El campo campo debe tener al menos :min kilobytes.',
        'string' => 'El campo campo debe tener al menos :min caracteres.',
        'array' => 'El campo campo debe tener al menos :min elementos.',
    ],
    'multiple_of' => 'El campo campo debe ser un múltiplo de :value.',
    'not_in' => 'El campo campo seleccionado es invalido.',
    'not_regex' => 'El formato del campo campo no es válido.',
    'numeric' => 'El campo campo debe ser un número.',
    'password' => 'La contraseña es incorrecta.',
    'present' => 'El campo campo debe estar presente.',
    'prohibited' => 'El campo campo no está permitido.',
    'prohibited_if' => 'El campo campo no está permitido cuando :other es :value.',
    'prohibited_unless' => 'El campo campo no está permitido si :other no está en :values.',
    'prohibits' => 'El campo campo no permite que :other esté presente.',
    'regex' => 'El formato del campo campo no es válido.',
    'required' => 'El campo campo es requerido.',
    'required_array_keys' => 'El campo campo debe contener entradas para: :values.',
    'required_if' => 'El campo campo es requerido cuando el campo :other es :value.',
    'required_unless' => 'El campo campo es requerido a menos que :other esté presente en :values.',
    'required_with' => 'El campo campo es requerido cuando :values está presente.',
    'required_with_all' => 'El campo campo es requerido cuando :values está presente.',
    'required_without' => 'El campo campo es requerido cuando :values no está presente.',
    'required_without_all' => 'El campo campo es requerido cuando ningún :values está presente.',
    'same' => 'El campo campo y :other debe coincidir.',
    'size' => [
        'numeric' => 'El campo campo debe ser :size.',
        'file' => 'El campo campo debe tener :size kilobytes.',
        'string' => 'El campo campo debe tener :size caracteres.',
        'array' => 'El campo campo debe contener :size elementos.',
    ],
    'starts_with' => 'El campo debe empezar con uno de los siguientes valores :values',
    'string' => 'El campo campo debe ser una cadena.',
    'timezone' => 'El campo campo debe ser una zona válida.',
    'unique' => 'El campo campo ya ha sido tomado.',
    'uploaded' => 'El campo campo no ha podido ser cargado.',
    'url' => 'El formato de campo no es válido.',
    'uuid' => 'El campo debe ser un UUID valido.',

    /*
    |--------------------------------------------------------------------------
    | Validación del idioma personalizado
    |--------------------------------------------------------------------------
    |
    |   Aquí puede especificar mensajes de validación personalizados para atributos utilizando el
    | convención "attribute.rule" para nombrar las líneas. Esto hace que sea rápido
    | especifique una línea de idioma personalizada específica para una regla de atributo dada.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Atributos de validación personalizados
    |--------------------------------------------------------------------------
    |
    | Las siguientes líneas de idioma se utilizan para intercambiar los marcadores de posición de atributo.
    | con algo más fácil de leer, como la dirección de correo electrónico.
    | de "email". Esto simplemente nos ayuda a hacer los mensajes un poco más limpios.
    |
    */

    'attributes' => [],

];
