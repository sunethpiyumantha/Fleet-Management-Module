@extends('layouts.app')

@section('title', 'Vehicle Registration')

@section('content')
<div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
    <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">
        <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">
            Declaration made by the owner of the vehicle in respect of the vehicles acquired on hire payment basis to the Army
        </h2>

        <!-- Form -->
        <form class="mb-8" style="margin-bottom: 2rem;" method="POST" enctype="multipart/form-data">
            <div style="display: flex; flex-direction: column; gap: 1.5rem; align-items: center;">
                <!-- Owner Section -->
                <div style="width: 100%; max-width: 540px; border: 1px solid #d1d5db; border-radius: 0.75rem; padding: 1rem; background-color: #f9fafb;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin-bottom: 1rem;">Owner Section</h3>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <!-- Row 1: Vehicle Registration Number + Full Name of Owner -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 500px;">
                            <div style="flex: 1 1 250px;">
                                <label for="registration_number" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Registration Number</label>
                                <input type="text" id="registration_number" name="registration_number" required
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1 1 250px;">
                                <label for="owner_full_name" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Full Name of Owner</label>
                                <input type="text" id="owner_full_name" name="owner_full_name" required
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                        </div>

                        <!-- Row 2: Owner's Name with Initials + Permanent Address -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 500px;">
                            <div style="flex: 1 1 250px;">
                                <label for="owner_initials_name" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Owner's Name with Initials</label>
                                <input type="text" id="owner_initials_name" name="owner_initials_name" required
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1 1 250px;">
                                <label for="owner_permanent_address" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Permanent Address</label>
                                <input type="text" id="owner_permanent_address" name="owner_permanent_address" required
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                        </div>

                        <!-- Row 3: Temporary Address + Phone Number -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 500px;">
                            <div style="flex: 1 1 250px;">
                                <label for="owner_temporary_address" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Temporary Address (if any)</label>
                                <input type="text" id="owner_temporary_address" name="owner_temporary_address"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1 1 250px;">
                                <label for="owner_phone_number" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Phone Number</label>
                                <input type="tel" id="owner_phone_number" name="owner_phone_number" required
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                        </div>

                        <!-- Row 4: Bank Account Details + Vehicle Type/Model -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 500px;">
                            <div style="flex: 1 1 250px;">
                                <label for="owner_bank_details" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Bank Account Details</label>
                                <input type="text" id="owner_bank_details" name="owner_bank_details" required
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1 1 250px;">
                                <label for="vehicle_type_model" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Type & Model</label>
                                <input type="text" id="vehicle_type_model" name="vehicle_type_model" required
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                        </div>

                        <!-- Row 5: Number of Seats (Registered + Current) -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 500px;">
                            <div style="flex: 1 1 250px;">
                                <label for="seats_registered" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Registered Seats</label>
                                <input type="number" id="seats_registered" name="seats_registered" min="1" required
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1 1 250px;">
                                <label for="seats_current" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Current Seats</label>
                                <input type="number" id="seats_current" name="seats_current" min="1" required
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                        </div>

                        <!-- Row 6: Registration Certificate + Insurance Certificate -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 500px;">
                            <div style="flex: 1 1 250px;">
                                <label for="registration_certificate" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Registration Certificate</label>
                                <input type="file" id="registration_certificate" name="registration_certificate" required
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.4rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1 1 250px;">
                                <label for="insurance_certificate" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Insurance Certificate</label>
                                <input type="file" id="insurance_certificate" name="insurance_certificate" required
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.4rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                        </div>

                        <!-- Row 7: Loan/Tax Details + Daily Rent -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 500px;">
                            <div style="flex: 1 1 250px;">
                                <label for="loan_tax_details" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Loan/Tax Details</label>
                                <input type="text" id="loan_tax_details" name="loan_tax_details"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1 1 250px;">
                                <label for="daily_rent" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Daily Rent</label>
                                <input type="number" id="daily_rent" name="daily_rent" min="0" step="0.01" required
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                        </div>

                        <!-- Row 8: Induction Date -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 500px;">
                            <div style="flex: 1 1 250px;">
                                <label for="induction_date" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Induction Date</label>
                                <input type="date" id="induction_date" name="induction_date" required
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1 1 250px;"></div> <!-- Empty div to maintain layout -->
                        </div>
                    </div>
                </div>

                <!-- Driver Section -->
                <div style="width: 100%; max-width: 540px; border: 1px solid #d1d5db; border-radius: 0.75rem; padding: 1rem; background-color: #f9fafb;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin-bottom: 1rem;">Driver Section</h3>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <!-- Row 9: Owner's Next of Kin + Driver Full Name -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 500px;">
                            <div style="flex: 1 1 250px;">
                                <label for="owner_next_of_kin" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Owner's Next of Kin</label>
                                <input type="text" id="owner_next_of_kin" name="owner_next_of_kin" required
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1 1 250px;">
                                <label for="driver_full_name" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Driver Full Name</label>
                                <input type="text" id="driver_full_name" name="driver_full_name" required
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                        </div>

                        <!-- Row 10: Driver Address + Driver's License Number -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 500px;">
                            <div style="flex: 1 1 250px;">
                                <label for="driver_address" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Driver Address</label>
                                <input type="text" id="driver_address" name="driver_address" required
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1 1 250px;">
                                <label for="driver_license_number" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Driver's License Number</label>
                                <input type="text" id="driver_license_number" name="driver_license_number" required
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                        </div>

                        <!-- Row 11: Driver's NIC Number + Driver's Next of Kin -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 500px;">
                            <div style="flex: 1 1 250px;">
                                <label for="driver_nic_number" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Driver's NIC Number</label>
                                <input type="text" id="driver_nic_number" name="driver_nic_number" required
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1 1 250px;">
                                <label for="driver_next_of_kin" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Driver's Next of Kin</label>
                                <input type="text" id="driver_next_of_kin" name="driver_next_of_kin" required
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Documents Section -->
                <div style="width: 100%; max-width: 540px; border: 1px solid #d1d5db; border-radius: 0.75rem; padding: 1rem; background-color: #f9fafb;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin-bottom: 1rem;">Additional Documents Section</h3>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <!-- Row 12: Additional Document 1 + Additional Document 2 -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 500px;">
                            <div style="flex: 1 1 250px;">
                                <label for="document_1" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Additional Document 1</label>
                                <input type="file" id="document_1" name="document_1"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.4rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1 1 250px;">
                                <label for="document_2" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Additional Document 2</label>
                                <input type="file" id="document_2" name="document_2"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.4rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                        </div>

                        <!-- Row 13: Additional Document 3 + Additional Document 4 -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 500px;">
                            <div style="flex: 1 1 250px;">
                                <label for="document_3" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Additional Document 3</label>
                                <input type="file" id="document_3" name="document_3"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.4rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1 1 250px;">
                                <label for="document_4" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Additional Document 4</label>
                                <input type="file" id="document_4" name="document_4"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.4rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div style="width: 100%; display: flex; justify-content: center;">
                    <button type="submit"
                            style="background-color: #f97316; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer; transition: background-color 0.2s;"
                            onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
                        <i class="fa-solid fa-plus-circle" style="margin-right: 0.25rem;"></i> Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection