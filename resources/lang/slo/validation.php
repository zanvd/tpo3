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

    'accepted'             => ':attribute mora biti sprejet.',
    'active_url'           => ':attribute ni veljaven URL naslov.',
    'after'                => ':attribute mora biti datum, ki je kasnejši od :date.',
    'after_or_equal'       => ':attribute mora biti datum, ki je kasnejši ali enak :date.',
    'alpha'                => ':attribute lahko vsebuje samo črke.',
    'alpha_dash'           => ':attribute lahko vsebuje samo črke, številke, podčrtaj in pomišljaj (- in _).',
    'alpha_num'            => ':attribute lahko vsebuje samo črke in številke.',
    'array'                => ':attribute mora biti seznam.',
    'before'               => ':attribute mora biti datum pred :date.',
    'before_or_equal'      => ':attribute mora biti datum pred ali enak :date.',
    'between'              => [
        'numeric' => ':attribute mora biti število med :min in :max.',
        'file'    => ':attribute mora biti datoteka večja od :min in manjša od :max kilobytov.',
        'string'  => ':attribute mora biti niz znakov, daljši od :min in krajši od :max.',
        'array'   => ':attribute mora biti seznam z več kot :min in manj kot :max elementi.',
    ],
    'boolean'              => ':attribute polje mora biti true (drži) ali false (ne drži).',
    'confirmed'            => ':attribute potrditev se ne ujema.',
    'date'                 => ':attribute ni veljaven datum.',
    'date_format'          => ':attribute se ne ujema s formatom :format.',
    'different'            => ':attribute in :other morata biti različna.',
    'digits'               => ':attribute mora vsebovati :digits številke.',
    'digits_between'       => ':attribute mora biti večji od :min in manjši od :max števk.',
    'dimensions'           => ':attribute ima neveljavne dimenzije slike.',
    'distinct'             => ':attribute polje ima podvojeno vrednost.',
    'email'                => ':attribute mora biti veljaven e-naslov.',
    'exists'               => 'Izbrani :attribute ni veljaven.',
    'file'                 => ':attribute mora biti datoteka.',
    'filled'               => ':attribute polje ne sme biti prazno.',
    'image'                => ':attribute mora biti slika.',
    'in'                   => 'Izbrani :attribute ni veljaven.',
    'in_array'             => ':attribute polje ne obstaja v :other.',
    'integer'              => ':attribute mora biti celo število.',
    'ip'                   => ':attribute mora biti veljaven IP naslov.',
    'json'                 => ':attribute mora biti veljaven JSON niz.',
    'max'                  => [
        'numeric' => ':attribute naj ne bo večji od :max.',
        'file'    => ':attribute datoteka naj ne bo večja od :max kilobytov.',
        'string'  => ':attribute naj ne bo daljši od :max znakov.',
        'array'   => ':attribute naj ne vsebuje več kot :max elementov.',
    ],
    'mimes'                => ':attribute naj bo datoteka tipa: :values.',
    'mimetypes'            => ':attribute naj bo datoteka tipa: :values.',
    'min'                  => [
        'numeric' => ':attribute naj bo večji ali enak :min.',
        'file'    => ':attribute datoteka naj bo velika vsaj :min kilobytov.',
        'string'  => ':attribute naj obsega vsaj :min znakov.',
        'array'   => ':attribute naj vsebuje vsaj :min elementov.',
    ],
    'not_in'               => 'Izbrani :attribute ni veljaven.',
    'numeric'              => ':attribute mora biti število.',
    'present'              => ':attribute polje mora biti izpolnjeno.',
    'regex'                => ':attribute format ni veljaven.',
    'required'             => ':attribute polje je zahtevano.',
    'required_if'          => ':attribute polje je zahtevano, kadar je  :other  :value.',
    'required_unless'      => ':attribute je zahtevano, razen kadar je :other v :values.',
    'required_with'        => ':attribute polje je zahtevano, kadar je :values prisoten.',
    'required_with_all'    => ':attribute polje je zahtevano, kadar je :values prisoten.',
    'required_without'     => ':attribute polje je zahtevano, kadar :values ni prisoten.',
    'required_without_all' => ':attribute polje je zahtevano, kadar noben od :values ni prisoten.',
    'same'                 => ':attribute in :other se morata ujemati.',
    'size'                 => [
        'numeric' => ':attribute naj bo velik :size.',
        'file'    => ':attribute naj bo velik :size kilobytov.',
        'string'  => ':attribute naj bo velik :size characters.',
        'array'   => ':attribute mora vsebovati :size elementov.',
    ],
    'string'               => ':attribute mora biti niz znakov.',
    'timezone'             => ':attribute mora biti veljaven časovni pas.',
    'unique'               => ':attribute je že bil prevzet.',
    'uploaded'             => ':attribute nalaganje ni uspelo.',
    'url'                  => ':attribute format je neveljaven.',

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
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
