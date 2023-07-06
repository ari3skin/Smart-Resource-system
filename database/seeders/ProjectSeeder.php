<?php

namespace Database\Seeders;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('projects')->insert([
            [
                'project_manager' => 102,
                'project_title' => 'Online Banking Portal',
                'project_description' => 'Develop a secure and user-friendly online banking portal with features such
                                          as balance inquiries, fund transfers, and transaction history.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'project_manager' => 101,
                'project_title' => 'Mobile Banking App',
                'project_description' => 'Design and build a mobile banking application compatible with iOS and Android devices,
                                          allowing customers to access their accounts and perform banking transactions on the go.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'project_manager' => 102,
                'project_title' => 'Fraud Detection System',
                'project_description' => 'Implement an advanced fraud detection system that monitors banking transactions in real-time,
                                          detects suspicious activities, and alerts the appropriate personnel for further investigation.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'project_manager' => 101,
                'project_title' => 'ATM Network Upgrade',
                'project_description' => 'Upgrade the existing ATM network with modern machines that support features like cordless
                                          withdrawals, deposit automation, and enhanced security measures.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'project_manager' => 102,
                'project_title' => 'Customer Relationship Management System',
                'project_description' => 'Develop a comprehensive CRM system that allows bank staff to manage customer interactions,
                                          track leads, and streamline sales and marketing processes.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'project_manager' => 101,
                'project_title' => 'Data Analytics Platform',
                'project_description' => 'Build a data analytics platform that leverages customer data and transactional information to
                                          gain insights, identify patterns, and support strategic decision-making.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'project_manager' => 102,
                'project_title' => 'Payment Gateway Integration',
                'project_description' => 'Integrate a secure and reliable payment gateway into the bank\'s systems,
                                          enabling customers to make online payments and process transactions seamlessly.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'project_manager' => 101,
                'project_title' => 'Credit Scoring Model Enhancement',
                'project_description' => 'Enhance the bank\'s credit scoring model by incorporating additional data sources,
                                          refining risk assessment algorithms, and improving the accuracy of credit decisions.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'project_manager' => 102,
                'project_title' => 'Branch Network Expansion',
                'project_description' => 'Plan and execute the expansion of the bank\'s branch network by opening new branches
                                          in strategic locations to enhance customer reach and service accessibility.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'project_manager' => 101,
                'project_title' => 'DigitalTransformation Initiative',
                'project_description' => 'Lead a digital transformation initiative within the bank, driving the adoption of new technologies,
                                          optimizing processes, and improving customer experiences across all channels.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'project_manager' => 102,
                'project_title' => 'Cyber-security Enhancement',
                'project_description' => 'Implement robust cyber security measures and protocols to safeguard the bank\'s systems, networks,
                                          and customer data from potential threats, vulnerabilities, and cyber attacks.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'project_manager' => 101,
                'project_title' => 'Loan Management System',
                'project_description' => 'Develop an efficient loan management system that automates loan origination, processing, and servicing,
                                          ensuring accurate calculations, timely approvals, and seamless tracking of loan applications.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'project_manager' => 102,
                'project_title' => 'Risk Assessment Framework',
                'project_description' => 'Establish a comprehensive risk assessment framework to identify, assess, and mitigate risks across different
                                          areas of the bank\'s operations, including credit, market, operational, and regulatory risks.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'project_manager' => 101,
                'project_title' => 'Wealth Management Platform',
                'project_description' => 'Build an integrated wealth management platform that provides personalized financial planning,
                                          investment advisory services, and portfolio management solutions to high-net-worth individuals and institutional clients.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
//        for ($i = 0; $i < 9; $i++) {
//            Project::factory()->create();
//        }
    }
}
