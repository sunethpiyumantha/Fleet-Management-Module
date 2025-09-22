@extends('layouts.app')

@section('title', 'Vehicle Request Management')

@section('content')

<div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
    <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">
        <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">Vehicle Request Management 2</h2>

        <!-- Success Message -->
        <div style="background-color: #d1fae5; color: #065f46; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; display: none;">
            Success message here
        </div>

        <!-- Error Messages -->
        <div style="background-color: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; display: none;">
            <ul style="margin: 0; padding-left: 1rem; list-style-type: disc;">
                <li>Error message here</li>
            </ul>
        </div>

        <!-- Form -->
        <form class="mb-8" style="margin-bottom: 2rem;">
            <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1 1 250px;">
                        <label for="request_type" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Request Type</label>
                        <select id="request_type" name="request_type" required
                                style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                            <option value="" disabled selected>Select Request Type</option>
                            <option value="replacement">Vehicle replacement</option>
                            <option value="new_approval">Taking over a vehicle based on a new approval</option>
                        </select>
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="cat_id" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Category</label>
                        <select id="cat_id" name="cat_id" required
                                style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                            <option value="" disabled selected>Select Category</option>
                            <option value="1">Category 1</option>
                            <option value="2">Category 2</option>
                        </select>
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="sub_cat_id" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Sub Category</label>
                        <select id="sub_cat_id" name="sub_cat_id" required
                                style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                            <option value="" disabled selected>Select Sub-Category</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1 1 250px;">
                        <label for="required_quantity" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Required Quantity</label>
                        <input type="number" id="required_quantity" name="qty" min="1" required
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="vehicle_book" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Letter</label>
                        <input type="file" id="vehicle_book" name="vehicle_book" accept=".pdf,.doc,.docx,.jpg,.png" required
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                    </div>
                    
                </div>
                <div style="width: 100%; display: flex; justify-content: center;">
                    <button type="submit"
                            style="background-color: #f97316; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer;"
                            onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
                        <i class="fa-solid fa-plus-circle" style="margin-right: 0.25rem;"></i> Submit
                    </button>
                </div>
            </div>
        </form>

        <!-- Search Form -->
        <form style="margin-bottom: 1.5rem;">
            <div style="display: flex; gap: 1rem; align-items: center;">
                <input type="text" name="search" placeholder="Search by Serial Number, Request Type, Category, Sub-Category, or Status"
                       style="flex: 1; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; font-size: 0.875rem;">
                <button type="submit" style="background-color: #f97316; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer;"
                        onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
                    Search
                </button>
            </div>
        </form>

        <!-- Table -->
        <table id="vehicleTable" style="width: 100%; border-collapse: collapse; border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden;">
            <thead style="background-color: #f97316; color: white;">
                <tr>
                    <th style="padding: 0.75rem; cursor: pointer;">Serial Number ▲▼</th>
                    <th style="padding: 0.75rem; cursor: pointer;">Request Type ▲▼</th>
                    <th style="padding: 0.75rem; cursor: pointer;">Vehicle Category ▲▼</th>
                    <th style="padding: 0.75rem; cursor: pointer;">Sub Category ▲▼</th>
                    <th style="padding: 0.75rem; cursor: pointer;">Quantity ▲▼</th>
                    <th style="padding: 0.75rem; cursor: pointer;">Status ▲▼</th>
                    <th style="padding: 0.75rem;">Vehicle Letter</th>
                    <th style="padding: 0.75rem; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <tr>
                    <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">12345</td>
                    <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">Vehicle Replacement</td>
                    <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">Category 1</td>
                    <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">Sub Category 1</td>
                    <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">2</td>
                    <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">Pending</td>
                    <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6; text-align: center;">
                        <button style="background-color: #16a34a; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; border: none;">
                            <i class="fa-solid fa-image"></i> View
                        </button>
                    </td>
                    <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid #f3f4f6;">
                        <div style="display: flex; justify-content: center; gap: 0.5rem;">
                            <button style="background-color: #16a34a; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; font-size: 0.875rem; font-weight: 500; transition: background-color 0.2s ease, transform 0.1s ease; cursor: pointer;"
                                    onmouseover="this.style.backgroundColor='#13893b'; this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.backgroundColor='#16a34a'; this.style.transform='scale(1)'">
                                Update
                            </button>
                            <button style="background-color: #dc2626; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; font-size: 0.875rem; font-weight: 500; transition: background-color 0.2s ease, transform 0.1s ease; cursor: pointer;"
                                    onmouseover="this.style.backgroundColor='#b91c1c'; this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.backgroundColor='#dc2626'; this.style.transform='scale(1)'">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="9" style="padding: 0.75rem; text-align: center; border-bottom: 1px solid #f3f4f6;">No vehicle requests found.</td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <div style="margin-top: 1rem;">
            <nav style="display: flex; justify-content: center; gap: 0.5rem;">
                <a href="#" style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; text-decoration: none; color: #374151;">Previous</a>
                <a href="#" style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; text-decoration: none; color: #374151;">1</a>
                <a href="#" style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; text-decoration: none; color: #374151;">Next</a>
            </nav>
        </div>
    </div>
</div>

<!-- File Modal (for Images and Vehicle Book) -->
<div id="fileModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center;">
    <div style="background: white; padding: 1.5rem; border-radius: 0.5rem; max-width: 90%; max-height: 90%; overflow: auto;">
        <h3 id="modalTitle" style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem;">Vehicle File</h3>
        <div id="fileContainer" style="display: flex; flex-wrap: wrap; gap: 1rem;">
            <img src="placeholder.jpg" style="max-width: 200px; max-height: 200px; border-radius: 0.25rem;" />
        </div>
        <button style="margin-top: 1rem; background-color: #f97316; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer;"
                onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
            Close
        </button>
    </div>
</div>

<style>
    /* Ensure modal images and files are responsive */
    #fileContainer img {
        width: 100%;
        height: auto;
        object-fit: contain;
    }
    #fileContainer a {
        font-size: 0.875rem;
        font-weight: 500;
    }
</style>
@endsection