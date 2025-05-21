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
    'active_url'           => ':attribute ليس عنوان URL صالحًا.',
    'after'                => 'يجب أن يكون :attribute تاريخًا بعد :date.',
    'after_or_equal'       => 'يجب أن يكون :attribute تاريخًا بعد أو يساوي :date.',
    'alpha'                => 'يجب أن يحتوي :attribute على أحرف فقط.',
    'alpha_dash'           => 'يجب أن يحتوي :attribute على أحرف وأرقام وشرطات فقط.',
    'alpha_num'            => 'يجب أن يحتوي :attribute على أحرف وأرقام فقط.',
    'array'                => 'يجب أن يكون :attribute مصفوفة.',
    'before'               => 'يجب أن يكون :attribute تاريخًا قبل :date.',
    'before_or_equal'      => 'يجب أن يكون :attribute تاريخًا قبل أو يساوي :date.',
    'between'              => [
        'numeric' => 'يجب أن يكون :attribute بين :min و :max.',
        'file'    => 'يجب أن يكون :attribute بين :min و :max كيلوبايت.',
        'string'  => 'يجب أن يكون :attribute بين :min و :max حروف.',
        'array'   => 'يجب أن يحتوي :attribute على عدد عناصر بين :min و :max.',
    ],
    'boolean'              => 'يجب أن يكون :attribute صحيح أو خطأ.',
    'confirmed'            => 'تأكيد :attribute غير متطابق.',
    'date'                 => ':attribute ليس تاريخًا صالحًا.',
    'date_format'          => ':attribute لا يتطابق مع الصيغة :format.',
    'different'            => 'يجب أن يكون :attribute و :other مختلفين.',
    'digits'               => 'يجب أن يكون :attribute :digits أرقام.',
    'digits_between'       => 'يجب أن يكون :attribute بين :min و :max أرقام.',
    'dimensions'           => ':attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct'             => ':attribute يحتوي على قيمة مكررة.',
    'email'                => 'يجب أن يكون :attribute عنوان بريد إلكتروني صالح.',
    'exists'               => ':attribute المحدد غير صالح.',
    'file'                 => 'يجب أن يكون :attribute ملفًا.',
    'filled'               => ':attribute مطلوب.',
    'gt'                   => [
        'numeric' => 'يجب أن يكون :attribute أكبر من :value.',
        'file'    => 'يجب أن يكون :attribute أكبر من :value كيلوبايت.',
        'string'  => 'يجب أن يكون :attribute أكبر من :value حروف.',
        'array'   => 'يجب أن يحتوي :attribute على أكثر من :value عناصر.',
    ],
    'gte'                  => [
        'numeric' => 'يجب أن يكون :attribute أكبر من أو يساوي :value.',
        'file'    => 'يجب أن يكون :attribute أكبر من أو يساوي :value كيلوبايت.',
        'string'  => 'يجب أن يكون :attribute أكبر من أو يساوي :value حروف.',
        'array'   => 'يجب أن يحتوي :attribute على :value عناصر أو أكثر.',
    ],
    'image'                => 'يجب أن يكون :attribute صورة.',
    'in'                   => ':attribute المحدد غير صالح.',
    'in_array'             => ':attribute غير موجود في :other.',
    'integer'              => 'يجب أن يكون :attribute عددًا صحيحًا.',
    'ip'                   => 'يجب أن يكون :attribute عنوان IP صالحًا.',
    'ipv4'                 => 'يجب أن يكون :attribute عنوان IPv4 صالحًا.',
    'ipv6'                 => 'يجب أن يكون :attribute عنوان IPv6 صالحًا.',
    'json'                 => 'يجب أن يكون :attribute نصًا بصيغة JSON.',
    'lt'                   => [
        'numeric' => 'يجب أن يكون :attribute أقل من :value.',
        'file'    => 'يجب أن يكون :attribute أقل من :value كيلوبايت.',
        'string'  => 'يجب أن يكون :attribute أقل من :value حروف.',
        'array'   => 'يجب أن يحتوي :attribute على أقل من :value عناصر.',
    ],
    'lte'                  => [
        'numeric' => 'يجب أن يكون :attribute أقل من أو يساوي :value.',
        'file'    => 'يجب أن يكون :attribute أقل من أو يساوي :value كيلوبايت.',
        'string'  => 'يجب أن يكون :attribute أقل من أو يساوي :value حروف.',
        'array'   => 'يجب ألا يحتوي :attribute على أكثر من :value عناصر.',
    ],
    'max'                  => [
        'numeric' => 'يجب ألا يتجاوز :attribute :max.',
        'file'    => 'يجب ألا يتجاوز :attribute :max كيلوبايت.',
        'string'  => 'يجب ألا يتجاوز :attribute :max حروف.',
        'array'   => 'يجب ألا يحتوي :attribute على أكثر من :max عناصر.',
    ],
    'mimes'                => 'يجب أن يكون :attribute ملفًا من نوع: :values.',
    'mimetypes'            => 'يجب أن يكون :attribute ملفًا من نوع: :values.',
    'min'                  => [
        'numeric' => 'يجب أن يكون :attribute على الأقل :min.',
        'file'    => 'يجب أن يكون :attribute على الأقل :min كيلوبايت.',
        'string'  => 'يجب أن يكون :attribute على الأقل :min حروف.',
        'array'   => 'يجب أن يحتوي :attribute على الأقل :min عناصر.',
    ],
    'not_in'               => ':attribute المحدد غير صالح.',
    'not_regex'            => 'صيغة :attribute غير صالحة.',
    'numeric'              => 'يجب أن يكون :attribute رقمًا.',
    'present'              => 'يجب أن يكون :attribute موجودًا.',
    'regex'                => 'صيغة :attribute غير صالحة.',
    'required'             => ':attribute مطلوب.',
    'required_if'          => ':attribute مطلوب عندما :other يساوي :value.',
    'required_unless'      => ':attribute مطلوب إلا إذا :other موجود في :values.',
    'required_with'        => ':attribute مطلوب عندما :values موجود.',
    'required_with_all'    => ':attribute مطلوب عندما :values موجود.',
    'required_without'     => ':attribute مطلوب عندما :values غير موجود.',
    'required_without_all' => ':attribute مطلوب عندما لا يوجد أي من :values موجود.',
    'same'                 => 'يجب أن يتطابق :attribute مع :other.',
    'size'                 => [
        'numeric' => 'يجب أن يكون :attribute :size.',
        'file'    => 'يجب أن يكون :attribute :size كيلوبايت.',
        'string'  => 'يجب أن يكون :attribute :size حروف.',
        'array'   => 'يجب أن يحتوي :attribute على :size عناصر.',
    ],
    'string'               => 'يجب أن يكون :attribute نصًا.',
    'timezone'             => 'يجب أن يكون :attribute منطقة زمنية صالحة.',
    'unique'               => ':attribute مستخدم من قبل.',
    'uploaded'             => 'فشل تحميل :attribute.',
    'url'                  => 'صيغة :attribute غير صالحة.',

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

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

    'attributes' => [
        "slug" => "الرابط",
        "name" => "الاسم",
        "description" => "الوصف",
        "image" => "الصورة",
        "added_by_id" => "المضاف بواسطة",
        "email" => "البريد الإلكتروني",
        "password" => "كلمة المرور",
        "phone" => "رقم الهاتف",
        "is_active" => "الحالة",
        "role" => "الصلاحية",
        "ar.description" => "الوصف بالعربية",
        "ar.name" => "الاسم بالعربية",
        "ar.meta_title" => "عنوان الصفحة بالعربية",
        "ar.meta_description" => "وصف الصفحة بالعربية",
        "ar.meta_keywords" => "كلمات البحث بالعربية",
        "en.description" => "الوصف بالانجليزية",
        "en.name" => "الاسم بالانجليزية",
        "en.meta_title" => "عنوان الصفحة بالانجليزية",
        "en.meta_description" => "وصف الصفحة بالانجليزية",
        "en.meta_keywords" => "كلمات البحث بالانجليزية",

    ],

];
