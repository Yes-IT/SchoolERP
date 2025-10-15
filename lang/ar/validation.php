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

    'accepted'             => 'يجب قبول :attribute.',
    'accepted_if'          => 'يجب قبول :attribute عندما يكون :other هو :value.',
    'active_url'           => ':attribute ليس عنوان URL صالحاً.',
    'after'                => 'يجب أن يكون :attribute تاريخاً بعد :date.',
    'after_or_equal'       => 'يجب أن يكون :attribute تاريخاً بعد أو يساوي :date.',
    'alpha'                => 'يجب أن يحتوي :attribute على حروف فقط.',
    'alpha_dash'           => 'يجب أن يحتوي :attribute على حروف وأرقام وشرطات وشرطات سفلية فقط.',
    'alpha_num'            => 'يجب أن يحتوي :attribute على حروف وأرقام فقط.',
    'array'                => 'يجب أن يكون :attribute مصفوفة.',
    'before'               => 'يجب أن يكون :attribute تاريخاً قبل :date.',
    'before_or_equal'      => 'يجب أن يكون :attribute تاريخاً قبل أو يساوي :date.',
    'between'              => [
        'array'   => 'يجب أن يحتوي :attribute على عدد عناصر بين :min و :max.',
        'file'    => 'يجب أن يكون حجم :attribute بين :min و :max كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute بين :min و :max.',
        'string'  => 'يجب أن يكون طول النص :attribute بين :min و :max حرفاً.',
    ],
    'boolean'              => 'يجب أن يكون حقل :attribute إما true أو false.',
    'confirmed'            => 'تأكيد :attribute غير متطابق.',
    'current_password'     => 'كلمة المرور غير صحيحة.',
    'date'                 => ':attribute ليس تاريخاً صالحاً.',
    'date_equals'          => 'يجب أن يكون :attribute تاريخاً يساوي :date.',
    'date_format'          => ':attribute لا يتوافق مع الشكل :format.',
    'declined'             => 'يجب رفض :attribute.',
    'declined_if'          => 'يجب رفض :attribute عندما يكون :other هو :value.',
    'different'            => 'يجب أن يكون :attribute و :other مختلفين.',
    'digits'               => 'يجب أن يتكون :attribute من :digits رقماً.',
    'digits_between'       => 'يجب أن يكون :attribute بين :min و :max رقماً.',
    'dimensions'           => 'أبعاد صورة :attribute غير صالحة.',
    'distinct'             => 'حقل :attribute يحتوي على قيمة مكررة.',
    'doesnt_start_with'    => ':attribute لا يمكن أن يبدأ بأحد القيم التالية: :values.',
    'email'                => 'يجب أن يكون :attribute عنوان بريد إلكتروني صالح.',
    'ends_with'            => 'يجب أن ينتهي :attribute بأحد القيم التالية: :values.',
    'enum'                 => ':attribute المحدد غير صالح.',
    'exists'               => ':attribute المحدد غير صالح.',
    'file'                 => 'يجب أن يكون :attribute ملفاً.',
    'filled'               => 'حقل :attribute يجب أن يحتوي على قيمة.',
    'gt'                   => [
        'array'   => 'يجب أن يحتوي :attribute على أكثر من :value عنصر.',
        'file'    => 'يجب أن يكون حجم :attribute أكبر من :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute أكبر من :value.',
        'string'  => 'يجب أن يكون طول النص :attribute أكثر من :value حرفاً.',
    ],
    'gte'                  => [
        'array'   => 'يجب أن يحتوي :attribute على الأقل :value عنصر.',
        'file'    => 'يجب أن يكون حجم :attribute أكبر من أو يساوي :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute أكبر من أو تساوي :value.',
        'string'  => 'يجب أن يكون طول النص :attribute على الأقل :value حرفاً.',
    ],
    'image'                => 'يجب أن يكون :attribute صورة.',
    'in'                   => ':attribute المحدد غير صالح.',
    'in_array'             => 'حقل :attribute غير موجود في :other.',
    'integer'              => 'يجب أن يكون :attribute عدداً صحيحاً.',
    'ip'                   => 'يجب أن يكون :attribute عنوان IP صالحاً.',
    'ipv4'                 => 'يجب أن يكون :attribute عنوان IPv4 صالحاً.',
    'ipv6'                 => 'يجب أن يكون :attribute عنوان IPv6 صالحاً.',
    'json'                 => 'يجب أن يكون :attribute نص JSON صالح.',
    'lt'                   => [
        'array'   => 'يجب أن يحتوي :attribute على أقل من :value عنصر.',
        'file'    => 'يجب أن يكون حجم :attribute أقل من :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute أقل من :value.',
        'string'  => 'يجب أن يكون طول النص :attribute أقل من :value حرفاً.',
    ],
    'lte'                  => [
        'array'   => 'يجب أن لا يحتوي :attribute على أكثر من :value عنصر.',
        'file'    => 'يجب أن يكون حجم :attribute أقل من أو يساوي :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute أقل من أو تساوي :value.',
        'string'  => 'يجب أن يكون طول النص :attribute أقل من أو يساوي :value حرفاً.',
    ],
    'mac_address'          => 'يجب أن يكون :attribute عنوان MAC صالحاً.',
    'max'                  => [
        'array'   => 'يجب أن لا يحتوي :attribute على أكثر من :max عنصر.',
        'file'    => 'يجب أن لا يتجاوز حجم :attribute :max كيلوبايت.',
        'numeric' => 'يجب أن لا تتجاوز قيمة :attribute :max.',
        'string'  => 'يجب أن لا يتجاوز طول النص :attribute :max حرفاً.',
    ],
    'mimes'                => 'يجب أن يكون :attribute ملفاً من نوع: :values.',
    'mimetypes'            => 'يجب أن يكون :attribute ملفاً من نوع: :values.',
    'min'                  => [
        'array'   => 'يجب أن يحتوي :attribute على الأقل :min عنصر.',
        'file'    => 'يجب أن يكون حجم :attribute على الأقل :min كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute على الأقل :min.',
        'string'  => 'يجب أن يكون طول النص :attribute على الأقل :min حرفاً.',
    ],
    'multiple_of'          => 'يجب أن تكون قيمة :attribute من مضاعفات :value.',
    'not_in'               => ':attribute المحدد غير صالح.',
    'not_regex'            => 'صيغة :attribute غير صالحة.',
    'numeric'              => 'يجب أن يكون :attribute رقماً.',
    'password'             => [
        'letters'       => 'يجب أن يحتوي :attribute على حرف واحد على الأقل.',
        'mixed'         => 'يجب أن يحتوي :attribute على حرف كبير وحرف صغير على الأقل.',
        'numbers'       => 'يجب أن يحتوي :attribute على رقم واحد على الأقل.',
        'symbols'       => 'يجب أن يحتوي :attribute على رمز واحد على الأقل.',
        'uncompromised' => ':attribute ظهر في تسريب بيانات. الرجاء اختيار :attribute مختلف.',
    ],
    'present'              => 'يجب تقديم حقل :attribute.',
    'prohibited'           => 'حقل :attribute محظور.',
    'prohibited_if'        => 'حقل :attribute محظور عندما يكون :other هو :value.',
    'prohibited_unless'    => 'حقل :attribute محظور ما لم يكن :other ضمن :values.',
    'prohibits'            => 'حقل :attribute يحظر تواجد :other.',
    'regex'                => 'صيغة :attribute غير صالحة.',
    'required'             => 'حقل :attribute مطلوب.',
    'required_array_keys'  => 'حقل :attribute يجب أن يحتوي على مدخلات لـ: :values.',
    'required_if'          => 'حقل :attribute مطلوب عندما يكون :other هو :value.',
    'required_unless'      => 'حقل :attribute مطلوب ما لم يكن :other ضمن :values.',
    'required_with'        => 'حقل :attribute مطلوب عندما يكون :values موجوداً.',
    'required_with_all'    => 'حقل :attribute مطلوب عندما تكون :values موجودة.',
    'required_without'     => 'حقل :attribute مطلوب عندما لا يكون :values موجوداً.',
    'required_without_all' => 'حقل :attribute مطلوب عندما لا تكون أي من :values موجودة.',
    'same'                 => 'يجب أن يتطابق :attribute مع :other.',
    'size'                 => [
        'array'   => 'يجب أن يحتوي :attribute على :size عنصر.',
        'file'    => 'يجب أن يكون حجم :attribute :size كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية لـ :size.',
        'string'  => 'يجب أن يكون طول النص :attribute :size حرفاً.',
    ],
    'starts_with'          => 'يجب أن يبدأ :attribute بأحد القيم التالية: :values.',
    'string'               => 'يجب أن يكون :attribute نصاً.',
    'timezone'             => 'يجب أن يكون :attribute منطقة زمنية صالحة.',
    'unique'               => 'قيمة :attribute مُستخدمة من قبل.',
    'uploaded'             => 'فشل في تحميل :attribute.',
    'url'                  => 'صيغة رابط :attribute غير صالحة.',
    'uuid'                 => 'يجب أن يكون :attribute رقم UUID صالح.',

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

    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'رسالة-مخصصة',
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

    'attributes'           => [],

];