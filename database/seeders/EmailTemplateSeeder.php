<?php

namespace Database\Seeders;

use App\Models\EmailTemplate\EmailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $emailTemplates = Config::get('email-template');
        if (count($emailTemplates)>0) {
            foreach ($emailTemplates as $roles) {
                if (!empty($roles) && is_array($roles)) {
                    foreach ($roles as $r => $types) {
                        if (!empty($types) && is_array($types)) {
                            foreach ($types as $t => $type) {
                                // dd($r);
                                $type['role'] = $r;
                                $type['type'] = $t;
                                $type['accepted_inputs'] = implode(',', $type['accepted_inputs']);
                                $emailTemplate = EmailTemplate::where('role', $r)->where('type', $t)->where('identifier', $type['identifier'])->first();
                                if (empty($emailTemplate)) {
                                    EmailTemplate::create($type);
                                } else {
                                    $emailTemplate->update($type);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
