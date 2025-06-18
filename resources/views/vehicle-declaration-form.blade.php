@extends('layouts.app')

@section('title', 'Vehicle Registration')

@section('content')
<div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem; font-family: Arial, sans-serif;">
    <div style="background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%); border: 2px solid #f97316; border-radius: 1.5rem; box-shadow: 0 12px 20px -5px rgba(0,0,0,0.15), 0 6px 8px -4px rgba(0,0,0,0.1); padding: 2rem; transition: transform 0.3s ease;">
        <h2 style="font-size: 2rem; font-weight: 700; color: #ea580c; text-align: center; margin-bottom: 2rem; text-transform: uppercase; letter-spacing: 1px; animation: fadeIn 0.5s ease-in;">
            Declaration for Vehicle Hire to Army
        </h2>

        <!-- Form -->
        <form class="mb-8" style="margin-bottom: 2rem;" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display: flex; flex-direction: column; gap: 2rem; align-items: center;">
                <!-- Tab Navigation -->
                <div style="display: flex; gap: 0.75rem; justify-content: center; margin-bottom: 1.5rem; background: #f3f4f6; padding: 0.25rem; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <button type="button" class="tab-button active" onclick="openTab('owner')" style="background: linear-gradient(90deg, #f97316 0%, #ea580c 100%); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.375rem; cursor: pointer; transition: all 0.3s ease; font-weight: 600; position: relative; overflow: hidden;">
                        Owner
                        <span style="position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: rgba(255,255,255,0.2); transform: skew(-20deg); transition: all 0.4s ease;" class="hover-effect"></span>
                    </button>
                    <button type="button" class="tab-button" onclick="openTab('driver')" style="background: #e5e7eb; color: #374151; padding: 0.75rem 1.5rem; border: none; border-radius: 0.375rem; cursor: pointer; transition: all 0.3s ease; font-weight: 600; position: relative; overflow: hidden;">
                        Driver
                        <span style="position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: rgba(255,255,255,0.2); transform: skew(-20deg); transition: all 0.4s ease;" class="hover-effect"></span>
                    </button>
                    <button type="button" class="tab-button" onclick="openTab('vehicle')" style="background: #e5e7eb; color: #374151; padding: 0.75rem 1.5rem; border: none; border-radius: 0.375rem; cursor: pointer; transition: all 0.3s ease; font-weight: 600; position: relative; overflow: hidden;">
                        Vehicle
                        <span style="position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: rgba(255,255,255,0.2); transform: skew(-20deg); transition: all 0.4s ease;" class="hover-effect"></span>
                    </button>
                    <button type="button" class="tab-button" onclick="openTab('additional')" style="background: #e5e7eb; color: #374151; padding: 0.75rem 1.5rem; border: none; border-radius: 0.375rem; cursor: pointer; transition: all 0.3s ease; font-weight: 600; position: relative; overflow: hidden;">
                        Additional Documents
                        <span style="position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: rgba(255,255,255,0.2); transform: skew(-20deg); transition: all 0.4s ease;" class="hover-effect"></span>
                    </button>
                </div>

                <!-- Tab Content -->
                <div id="owner-tab" class="tab-content" style="display: block; width: 100%; max-width: 640px; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.5rem; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.05); animation: slideIn 0.3s ease-out;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin-bottom: 1.5rem; border-bottom: 2px solid #f97316; padding-bottom: 0.5rem;">Owner Details</h3>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="registration_number" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Vehicle Reg. Number</label>
                                <input type="text" id="registration_number" name="registration_number" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="owner_full_name" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Full Name</label>
                                <input type="text" id="owner_full_name" name="owner_full_name" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="owner_initials_name" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Name with Initials</label>
                                <input type="text" id="owner_initials_name" name="owner_initials_name" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="owner_permanent_address" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Permanent Address</label>
                                <input type="text" id="owner_permanent_address" name="owner_permanent_address" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="owner_temporary_address" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Temporary Address (if any)</label>
                                <input type="text" id="owner_temporary_address" name="owner_temporary_address"
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="owner_phone_number" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Phone Number</label>
                                <input type="tel" id="owner_phone_number" name="owner_phone_number" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="owner_bank_details" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Bank Account Details</label>
                                <input type="text" id="owner_bank_details" name="owner_bank_details" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="vehicle_type" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Vehicle Type</label>
                                <select id="vehicle_type" name="vehicle_type" required
                                        style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem; appearance: none; background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="%23374151"><path d="M7 10l-5-5 1.41-1.41L7 7.17l4.59-4.58L12 5l-5 5z"/></svg>') no-repeat right 0.75rem center;"
                                        onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                                    <option value="" disabled selected>Select Vehicle Type</option>
                                </select>
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="vehicle_model" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Vehicle Model</label>
                                <select id="vehicle_model" name="vehicle_model" required
                                        style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem; appearance: none; background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="%23374151"><path d="M7 10l-5-5 1.41-1.41L7 7.17l4.59-4.58L12 5l-5 5z"/></svg>') no-repeat right 0.75rem center;"
                                        onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                                    <option value="" disabled selected>Select Vehicle Model</option>
                                </select>
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="seats_registered" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Registered Seats</label>
                                <input type="number" id="seats_registered" name="seats_registered" min="1" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="seats_current" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Current Seats</label>
                                <input type="number" id="seats_current" name="seats_current" min="1" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="loan_tax_details" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Loan/Tax Details</label>
                                <input type="text" id="loan_tax_details" name="loan_tax_details"
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="daily_rent" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Daily Rent</label>
                                <input type="number" id="daily_rent" name="daily_rent" min="0" step="0.01" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="induction_date" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Induction Date</label>
                                <input type="date" id="induction_date" name="induction_date" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                        </div>
                    </div>
                </div>

                <div id="driver-tab" class="tab-content" style="display: none; width: 100%; max-width: 640px; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.5rem; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.05); animation: slideIn 0.3s ease-out;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2933; margin-bottom: 1.5rem; border-bottom: 2px solid #f97316; padding-bottom: 0.5rem;">Driver Details</h3>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="owner_next_of_kin" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Owner's Next of Kin</label>
                                <input type="text" id="owner_next_of_kin" name="owner_next_of_kin" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="driver_full_name" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Driver Full Name</label>
                                <input type="text" id="driver_full_name" name="driver_full_name" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="driver_address" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Driver Address</label>
                                <input type="text" id="driver_address" name="driver_address" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="driver_license_number" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Driver's License No.</label>
                                <input type="text" id="driver_license_number" name="driver_license_number" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="driver_nic_number" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Driver's NIC Number</label>
                                <input type="text" id="driver_nic_number" name="driver_nic_number" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="driver_next_of_kin" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Driver's Next of Kin</label>
                                <input type="text" id="driver_next_of_kin" name="driver_next_of_kin" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                        </div>
                    </div>
                </div>

                <div id="vehicle-tab" class="tab-content" style="display: none; width: 100%; max-width: 640px; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.5rem; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.05); animation: slideIn 0.3s ease-out;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin-bottom: 1.5rem; border-bottom: 2px solid #f97316; padding-bottom: 0.5rem;">Vehicle Details</h3>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="civil_number" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Civil Number</label>
                                <input type="text" id="civil_number" name="civil_number" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="product_classification" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Product Classification</label>
                                <input type="text" id="product_classification" name="product_classification" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="engine_no" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Engine No</label>
                                <input type="text" id="engine_no" name="engine_no" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="chassis_number" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Chassis Number</label>
                                <input type="text" id="chassis_number" name="chassis_number" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="year_of_manufacture" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Year of Manufacture</label>
                                <input type="number" id="year_of_manufacture" name="year_of_manufacture" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="date_of_original_registration" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Date of Original Registration</label>
                                <input type="date" id="date_of_original_registration" name="date_of_original_registration" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="engine_capacity" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Engine Capacity</label>
                                <input type="text" id="engine_capacity" name="engine_capacity" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="section_4_w_2w" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Section 4 W/2W</label>
                                <input type="text" id="section_4_w_2w" name="section_4_w_2w" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="speedometer_hours" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Speedometer Hours at Takeover</label>
                                <input type="number" id="speedometer_hours" name="speedometer_hours" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="code_no" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Code No</label>
                                <input type="text" id="code_no" name="code_no" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="color" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Color</label>
                                <input type="text" id="color" name="color" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="pay_per_day" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Pay per Day</label>
                                <input type="number" id="pay_per_day" name="pay_per_day" min="0" step="0.01" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="type_of_fuel" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Type of Fuel</label>
                                <input type="text" id="type_of_fuel" name="type_of_fuel" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="tar_weight_capacity" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Tar Weight Capacity (Capacity if a Water Bowser)</label>
                                <input type="text" id="tar_weight_capacity" name="tar_weight_capacity" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="amount_of_fuel" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Amount of Fuel in the Tank at Takeover</label>
                                <input type="number" id="amount_of_fuel" name="amount_of_fuel" min="0" step="0.01" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="reason_for_taking_over" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Reason for Taking Over</label>
                                <input type="text" id="reason_for_taking_over" name="reason_for_taking_over" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="other_matters" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Other Matters</label>
                                <input type="text" id="other_matters" name="other_matters"
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 48%;"></div>
                        </div>
                    </div>
                </div>

                <div id="additional-tab" class="tab-content" style="display: none; width: 100%; max-width: 640px; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.5rem; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.05); animation: slideIn 0.3s ease-out;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin-bottom: 1.5rem; border-bottom: 2px solid #f97316; padding-bottom: 0.5rem;">Additional Documents</h3>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="registration_certificate" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Reg. Certificate</label>
                                <input type="file" id="registration_certificate" name="registration_certificate" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="insurance_certificate" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Insurance Certificate</label>
                                <input type="file" id="insurance_certificate" name="insurance_certificate" required
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="document_1" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Document 1</label>
                                <input type="file" id="document_1" name="document_1"
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="document_2" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Document 2</label>
                                <input type="file" id="document_2" name="document_2"
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="document_3" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Document 3</label>
                                <input type="file" id="document_3" name="document_3"
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 48%;">
                                <label for="document_4" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #4b5563;">Document 4</label>
                                <input type="file" id="document_4" name="document_4"
                                       style="width: 100%; height: 42px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 0.75rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#d1d5db'">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div style="display: flex; gap: 1.5rem; justify-content: center; width: 100%; margin-top: 1rem;">
                    
                    <button type="button" onclick="nextTab()" style="background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.5rem; cursor: pointer; transition: all 0.3s ease, transform 0.2s ease; font-weight: 600;"
                            onmouseover="this.style.background='linear-gradient(90deg, #2563eb 0%, #1d4ed8 100%)'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='linear-gradient(90deg, #3b82f6 0%, #2563eb 100%)'; this.style.transform='scale(1)'">Next</button>
                </div>

                <!-- Submit Button -->
                <div style="width: 100%; display: flex; justify-content: center; margin-top: 1.5rem;">
                    <button type="submit"
                            style="background: linear-gradient(90deg, #f97316 0%, #ea580c 100%); color: white; font-weight: 600; padding: 0.75rem 2rem; border-radius: 0.5rem; border: none; cursor: pointer; transition: all 0.3s ease, transform 0.2s ease; font-size: 1rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
                            onmouseover="this.style.background='linear-gradient(90deg, #ea580c 0%, #c2410c 100%)'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='linear-gradient(90deg, #f97316 0%, #ea580c 100%)'; this.style.transform='scale(1)'">
                        <i class="fa-solid fa-plus-circle" style="margin-right: 0.5rem;"></i> Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript for tab switching and dynamic vehicle model dropdown -->
<script>
    // Define vehicleModels to prevent runtime error
    const vehicleModels = {
        "car": ["Model A", "Model B", "Model C"],
        "truck": ["Model X", "Model Y", "Model Z"],
        // Add more vehicle types and models as needed
    };

    const vehicleTypeSelect = document.getElementById('vehicle_type');
    const vehicleModelSelect = document.getElementById('vehicle_model');

    vehicleTypeSelect.addEventListener('change', function() {
        const selectedType = this.value;
        vehicleModelSelect.innerHTML = '<option value="" disabled selected>Select Vehicle Model</option>';

        if (selectedType && vehicleModels[selectedType]) {
            vehicleModels[selectedType].forEach(model => {
                const option = document.createElement('option');
                option.value = model;
                option.textContent = model;
                vehicleModelSelect.appendChild(option);
            });
            vehicleModelSelect.disabled = false;
        } else {
            vehicleModelSelect.disabled = true;
        }
    });

    function openTab(tabName) {
        var i, tabcontent, tabbuttons;
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
            tabcontent[i].style.opacity = "0";
        }
        tabbuttons = document.getElementsByClassName("tab-button");
        for (i = 0; i < tabbuttons.length; i++) {
            tabbuttons[i].className = tabbuttons[i].className.replace(" active", "");
            tabbuttons[i].style.background = "#e5e7eb";
            tabbuttons[i].style.color = "#374151";
            tabbuttons[i].querySelector('.hover-effect').style.left = '-100%';
        }
        document.getElementById(tabName + '-tab').style.display = "block";
        setTimeout(() => document.getElementById(tabName + '-tab').style.opacity = "1", 10);
        event.currentTarget.className += " active";
        event.currentTarget.style.background = "linear-gradient(90deg, #f97316 0%, #ea580c 100%)";
        event.currentTarget.style.color = "white";
        event.currentTarget.querySelector('.hover-effect').style.left = '100%';
        setTimeout(() => event.currentTarget.querySelector('.hover-effect').style.left = '-100%', 400);
    }

    function nextTab() {
        var currentTab = document.getElementsByClassName("tab-button active")[0];
        var tabs = document.getElementsByClassName("tab-button");
        var nextIndex = Array.from(tabs).indexOf(currentTab) + 1;
        if (nextIndex < tabs.length) {
            tabs[nextIndex].click();
        }
    }
</script>

<!-- CSS Animations -->
<style>
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes slideIn {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .tab-button:hover .hover-effect {
        left: 100%;
    }
    @media (max-width: 48rem) {
        .tab-content, .tab-button {
            width: 100% !important;
            max-width: 100% !important;
        }
        .tab-button {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
        div[style*="flex-wrap: nowrap"] {
            flex-wrap: wrap;
        }
        div[style*="max-width: 48%"] {
            max-width: 100%;
            margin-bottom: 1rem;
        }
    }
</style>
@endsection