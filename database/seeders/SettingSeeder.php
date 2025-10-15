<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\SettingTranslate;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;


class SettingSeeder extends Seeder
{
    use CommonHelperTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schoolName = env('APP_NAME', 'School');
        $domain     = env('APP_DOMAIN', 'school.com');
        $appname    = Setting::create([
            'name'  => 'application_name',
            'value' => $schoolName. ' Management System',
        ]);
        $address = Setting::create([
            'name'  => 'address',
            'value' => 'Resemont Tower, House 148, Road 13/B, Block E Banani Dhaka 1213.',
        ]);
        $phone = Setting::create([
            'name'  => 'phone',
            'value' => '+62 8787 8787',
        ]);
        Setting::create([
            'name'  => 'email',
            'value' => 'info@' . $domain,
        ]);
        $school_about = Setting::create([
            'name'  => 'school_about',
            'value' => 'School Management Software (SMS) is a digital solution designed to simplify and automate administrative, academic, and operational tasks in educational institutions. It serves as a centralized platform to manage activities such as student records, attendance, fee collection, staff management, academic scheduling, and communication with parents.',
        ]);
        $footer_text = Setting::create([
            'name'  => 'footer_text',
            'value' => '© ' . Carbon::now()->year . ' ' . $schoolName . '. All rights reserved.',
        ]);
        Setting::create([
            'name'  => 'file_system',
            'value' => 'local',
        ]);
        Setting::create([
            'name'  => 'aws_access_key_id',
            'value' => 'AKIA3OGN2RWSJOR5UOTK',
        ]);
        Setting::create([
            'name'  => 'aws_secret_key',
            'value' => 'Vz18p5ELHI6BP9K7iZAzduu+sQCD/KkvbAwElmfX',
        ]);
        Setting::create([
            'name'  => 'aws_region',
            'value' => 'ap-southeast-1',
        ]);
        Setting::create([
            'name'  => 'aws_bucket',
            'value' => $schoolName,
        ]);
        Setting::create([
            'name'  => 'aws_endpoint',
            'value' => 'https://s3.ap-southeast-1.amazonaws.com',
        ]);

        // twillio sms

        Setting::create([
            'name'  => 'twilio_account_sid',
            'value' => 'AC246311d660594a872734080bbb03a18b',
        ]);
        Setting::create([
            'name'  => 'twilio_auth_token',
            'value' => '9e64cc0f85970ab0d0f055f541861742',
        ]);
        Setting::create([
            'name'  => 'twilio_phone_number',
            'value' => '+14422426457',
        ]);

        // recaptcha
        Setting::create([
            'name'  => 'recaptcha_sitekey',
            'value' => '6Lfn6nQhAAAAAKYauxvLddLtcqSn1yqn-HRn_CbN',
        ]);
        Setting::create([
            'name'  => 'recaptcha_secret',
            'value' => '6Lfn6nQhAAAAABOzRtEjhZYB49Dd4orv41thfh02',
        ]);
        Setting::create([
            'name'  => 'recaptcha_status',
            'value' => '0',
        ]);

        Setting::create([
            'name'  => 'mail_drive',
            'value' => 'smtp',
        ]);
        Setting::create([
            'name'  => 'mail_host',
            'value' => 'smtp.gmail.com',
        ]);
        Setting::create([
            'name'  => 'mail_address',
             'value' => 'info@' . $domain,

        ]);
        Setting::create([
            'name'  => 'from_name',
            'value' => $schoolName . ' - School Management System',

        ]);
        Setting::create([
            'name'  => 'mail_username',
            'value' => 'onestdev103@gmail.com',
        ]);

        // pass
        $mail_password = Crypt::encrypt('vjednrwfzumzixdo');
        Setting::create([
            'name'  => 'mail_password',
            'value' => $mail_password,
        ]);

        Setting::create([
            'name'  => 'mail_port',
            'value' => '587',
        ]);
        Setting::create([
            'name'  => 'encryption',
            'value' => 'tls',
        ]);
        Setting::create([
            'name'  => 'default_langauge',
            'value' => 'en',
        ]);
        Setting::create([
            'name'  => 'light_logo',
            'value' => 'backend/uploads/settings/light.png',
        ]);
        Setting::create([
            'name'  => 'dark_logo',
            'value' => 'backend/uploads/settings/dark.png',
        ]);
        Setting::create([
            'name'  => 'favicon',
            'value' => 'backend/uploads/settings/favicon.png',
        ]);
        Setting::create([
            'name'  => 'session',
            'value' => 1,
        ]);
        Setting::create([
            'name'  => 'currency_code',
            'value' => 'USD',
        ]);
        Setting::create([
            'name'  => 'map_key',
            'value' => "!1m18!1m12!1m3!1d3650.776241229233!2d90.40412657620105!3d23.790981078642808!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c72b14773d9d%3A0x21df6643cbfa879f!2sSookh!5e0!3m2!1sen!2sbd!4v1711600654298!5m2!1sen!2sbd",
        ]);
        // Setting::create([
        //     'name' => 'student_limit',
        //     'value' => Session::get('student_limit'),
        // ]);
        // Setting::create([
        //     'name' => 'staff_limit',
        //     'value' => Session::get('staff_limit'),
        // ]);
        // Setting::create([
        //     'name' => 'expiry_date',
        //     'value' => Session::get('expiry_date'),
        // ]);
        // Setting::create([
        //     'name' => 'features',
        //     'value' => Session::get('features'),
        // ]);

        if ($appname) {
            $row             = new SettingTranslate();
            $row->setting_id = $appname->id;
            $row->locale     = 'en';
            $row->name       = $appname->name;
            $row->value      = $appname->value;
            $row->save();

            $row             = new SettingTranslate();
            $row->setting_id = $appname->id;
            $row->locale     = 'bn';
            $row->name       = $appname->name;
            $row->value      = 'ওনেস্ট স্কুলড - স্কুল ম্যানেজমেন্ট সিস্টেম';
            $row->save();
        }
        if ($footer_text) {
            $row             = new SettingTranslate();
            $row->setting_id = $footer_text->id;
            $row->locale     = 'en';
            $row->name       = $footer_text->name;
            $row->value      = $footer_text->value;
            $row->save();

            $row             = new SettingTranslate();
            $row->setting_id = $footer_text->id;
            $row->locale     = 'bn';
            $row->name       = $footer_text->name;
            $row->value      = '© ' . Carbon::now()->year . ' ' . $schoolName;
            $row->save();

        }
        if ($address) {
            $row             = new SettingTranslate();
            $row->setting_id = $address->id;
            $row->locale     = 'en';
            $row->name       = $address->name;
            $row->value      = $address->value;
            $row->save();

            $row             = new SettingTranslate();
            $row->setting_id = $address->id;
            $row->locale     = 'bn';
            $row->name       = $address->name;
            $row->value      = 'রেসিমন্ট টাওয়ার, হাউজ 148, রোড 13/বি, ব্লক ই বনানী ঢাকা 1213।';
            $row->save();
        }
        if ($phone) {
            $row             = new SettingTranslate();
            $row->setting_id = $phone->id;
            $row->locale     = 'en';
            $row->name       = $phone->name;
            $row->value      = $phone->value;
            $row->save();

            $row             = new SettingTranslate();
            $row->setting_id = $phone->id;
            $row->locale     = 'bn';
            $row->name       = $phone->name;
            $row->value      = '+৬২ ৮৭৮৭ ৮৭৮৭';
            $row->save();
        }
        if ($school_about) {
            $row             = new SettingTranslate();
            $row->setting_id = $school_about->id;
            $row->locale     = 'en';
            $row->name       = $school_about->name;
            $row->value      = $school_about->value;
            $row->save();

            $row             = new SettingTranslate();
            $row->setting_id = $school_about->id;
            $row->locale     = 'bn';
            $row->name       = $school_about->name;
            $row->value      = setting('application_name') .  ' স্কুল ম্যানেজমেন্ট সফটওয়্যার (এসএমএস) হল একটি ডিজিটাল সমাধান যা শিক্ষা প্রতিষ্ঠানগুলিতে প্রশাসনিক, একাডেমিক এবং পরিচালনামূলক কাজগুলিকে সহজ এবং স্বয়ংক্রিয় করার জন্য ডিজাইন করা হয়েছে। এটি শিক্ষার্থীদের রেকর্ড, উপস্থিতি, ফি সংগ্রহ, কর্মী ব্যবস্থাপনা, একাডেমিক সময়সূচী এবং অভিভাবকদের সাথে যোগাযোগের মতো কার্যকলাপ পরিচালনা করার জন্য একটি কেন্দ্রীভূত প্ল্যাটফর্ম হিসেবে কাজ করে।';
            $row->save();
        }
    }
}
