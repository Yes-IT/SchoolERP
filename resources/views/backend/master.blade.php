<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1.0, user-scalable=0">
    <title>@yield('title', 'School Management System')</title>

    <!-- fabicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- slick slider -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css">

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- custom -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/superadmin.css') }}">

    @stack('styles')
</head>

<body>

    {{-- Main content --}}
    @yield('content')

    <!-- Jquery-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.5.3/dist/js/splide-extension-auto-scroll.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script src="frontend/js/common.js"></script>

    <script src="{{ global_asset('backend') }}/assets/js/custom.js"></script>
    <script>
        function changeLoginType(type) {
            const heading = document.getElementById("loginHeading");
            const buttons = document.querySelectorAll(".tablist-container button");

            // remove active from all
            buttons.forEach(btn => btn.classList.remove("active"));

            // add active to clicked button
            const clickedBtn = document.getElementById("tab-" + type);
            if (clickedBtn) {
                clickedBtn.classList.add("active");
            }

            // update heading text
            if (type === "student") {
                heading.textContent = "User Login";
            } else if (type === "parent") {
                heading.textContent = "Parent Login";
            } else if (type === "alumni") {
                heading.textContent = "Alumni Login";
            }
        }



        function togglePassword() {
            const passwordField = document.getElementById("password");
            const icon = document.getElementById("passwordToggleIcon");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.src = "/frontend/img/eye-open.svg"; // 👁 open eye
            } else {
                passwordField.type = "password";
                icon.src = "/frontend/img/eye-close.svg"; // 👁 closed eye
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".sidebar-menu-item .has-arrow").forEach(function(el) {
                el.addEventListener("click", function(e) {
                    e.preventDefault();
                    const parent = el.closest(".sidebar-menu-item");
                    parent.classList.toggle("open");
                });
            });
        });


        document.getElementById('ParentyearFilter').addEventListener('change', function() {
            let year = this.value;
            $.ajax({
                url: "{{ route('student.filterByYearParent') }}",
                type: "GET",
                data: {
                    year: year
                },
                success: function(response) {
                    $('#studentsTable').html(response.html); // Replace only tbody rows
                }
            });
        });


        document.getElementById('yearFilter').addEventListener('change', function() {
            let year = this.value;
            $.ajax({
                url: "{{ route('student.filterByYear') }}",
                type: "GET",
                data: {
                    year: year
                },
                success: function(response) {
                    $('#studentsTable').html(response.html); // Replace only tbody rows
                }
            });
        });










        $(document).on("click", ".dropdown-option", function() {
            let studentName = $(this).text().trim();
            let studentId = $(this).data("id");

            $(".dropdown-label").text(studentName);

            $.ajax({
                url: "{{ route('student.filterByName') }}",
                type: "GET",
                data: {
                    id: studentId
                }, // send id instead of name
                success: function(response) {
                    $("#studentsTable tbody").html(response.html);
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseText);
                }
            });
        });


        function hitDeleteRoute(id) {


            fetch(`/delete/${id}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json",
                    },
                })
                .then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert("Failed to delete. Please try again.");
                    }
                })
                .catch(() => alert("Error deleting student."));


        }



        function initStudentDropdown(studentId, studentName) {
            console.log("Student dropdown initialized");

            // Remove previous bindings to avoid duplicates
            $(document).off("click", ".dropdown-option");

            // Bind click event

            console.log(" Student option clicked");

            //let studentName ="test";
            //let studentId   = $(this).data("id");

            console.log("Selected Student:", studentName, "| ID:", studentId);

            // Update dropdown label
            $(".dropdown-label-parent").text(studentName);

            // AJAX request
            $.ajax({
                url: "{{ route('parent.filterByStudent') }}",
                type: "GET",
                data: {
                    id: studentId
                },
                beforeSend: function() {
                    console.log("⏳ Sending request to server with student_id:", studentId);
                },
                success: function(response) {
                    console.log("✅ Route triggered successfully");
                    console.log("Response received:", response);

                    if (response.html) {
                        $("#studentsTable tbody").html(response.html);
                    } else {
                        console.warn("⚠️ Response does not contain 'html'. Full response:", response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("❌ AJAX Error:");
                    console.error("Status:", status);
                    console.error("Error Message:", error);
                    console.error("Response Text:", xhr.responseText);
                },
                complete: function() {
                    console.log("ℹ️ AJAX request completed");
                }
            });

        }

        // Initialize on page load
        $(document).ready(function() {
            initStudentDropdown();
        });



        // fees group edit

        document.querySelectorAll(".edit-group-btn").forEach(button => {
            button.addEventListener("click", function() {
                let id = this.dataset.id;
                let form = document.getElementById("editGroupForm");

                // Set the correct action URL dynamically
                form.setAttribute("action", `/fees-group/update/${id}`);

                // Fill modal fields
                document.getElementById("edit_name").value = this.dataset.name;
                document.getElementById("edit_description").value = this.dataset.description;
            });
        });

        // delete  fees-group

        // document.addEventListener("DOMContentLoaded", function () {
        //     document.querySelectorAll(".delete-group-btn").forEach(button => {
        //         button.addEventListener("click", function () {
        //             const groupId = this.getAttribute("data-id");

        //             if (!confirm("Are you sure you want to delete this group?")) {
        //                 return;
        //             }

        //             fetch(`/fees-group/delete/${groupId}`, {
        //                 method: "DELETE",
        //                 headers: {
        //                     "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        //                     "Accept": "application/json"
        //                 }
        //             })
        //             .then(response => {
        //                 if (!response.ok) throw new Error("Failed to delete");
        //                 return response.json();
        //             })
        //             .then(data => {
        //                 alert(data.message || "Deleted successfully");
        //                 // Remove card from DOM
        //                 this.closest(".col-lg-4").remove();
        //             })
        //             .catch(error => {
        //                 console.error("Error:", error);
        //                 alert("Something went wrong while deleting the group");
        //             });
        //         });
        //     });
        // });

        function deletefeesgroup(button) {
            const groupId = button.getAttribute("data-id");



            fetch(`/fees-group/delete/${groupId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json",
                    }
                })
                .then(async response => {
                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || "Failed to delete group");
                    }
                    return response.json();
                })
                .then(data => {

                    const row = button.closest("tr");
                    if (row) row.remove();


                })
                .catch(error => {
                    console.error(error);
                    alert("Error: " + error.message);
                });
        }


        function searchFeesGroup() {
            const query = document.getElementById("searchGroup").value;

            fetch(`/fees-group/search?name=${encodeURIComponent(query)}`, {
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json",
                    }
                })
                .then(response => response.json())
                .then(groups => {
                    const container = document.getElementById("feesGroupCards");
                    container.innerHTML = "";

                    if (groups.length === 0) {
                        container.innerHTML = `<div class="col-12 text-center">
                <p class="text-muted">No matching groups found</p>
            </div>`;
                        return;
                    }

                    groups.forEach(group => {
                        const statusBadge = group.status == 1 ?
                            `<span class="cmn-tbl-btn green-bg">Active</span>` :
                            `<span class="cmn-tbl-btn red-bg">Inactive</span>`;

                        const card = document.createElement("div");
                        card.classList.add("col-lg-4", "col-md-6", "col-sm-12");
                        card.innerHTML = `
                <div class="ds-cmn-info-card h-200">
                    <div class="ds-cmn-ic-head d-flex justify-content-between align-items-center">
                        <h3 class="clr-primary mb-0">${group.name}</h3>
                        <div class="actions-wrp">${statusBadge}</div>
                    </div>

                    <div class="ds-cmn-ic-body">
                        <p>${group.description ?? ''}</p>
                    </div>

                    <div class="ds-cmn-ic-ftr actions-wrp d-flex justify-content-between align-items-center">
                        <p class="mb-0">450 students assigned</p>
                        <div class="btn-wrp d-flex gap-2">
                            <button type="button" class="edit-group-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#editgroup"
                                data-id="${group.id}"
                                data-name="${group.name}"
                                data-description="${group.description ?? ''}">
                                <img src="{{ asset('images/fees/edit-icon-primary.svg') }}" alt="Icon">
                            </button>

                            <button type="button"
                                data-id="${group.id}"
                                onclick="deletefeesgroup(this)">
                                <img src="{{ asset('images/fees/bin-icon.svg') }}" alt="Delete">
                            </button>
                        </div>
                    </div>
                </div>
            `;
                        container.appendChild(card);
                    });
                })
                .catch(error => {
                    console.error("Search error:", error);
                });
        }



        function filterFeesTypes() {
            const selectedCategory = document.getElementById('categoryFilter').value;

            fetch(`{{ route('fees-type.filter') }}?category=${encodeURIComponent(selectedCategory)}`, {
                    headers: {
                        "Accept": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('feesTypesTable');
                    tableBody.innerHTML = '';

                    if (data.length === 0) {
                        tableBody.innerHTML = `<tr><td colspan="7" class="text-center">No Fee Types Found</td></tr>`;
                        return;
                    }

                    data.forEach((row, index) => {
                        tableBody.innerHTML += `
                <tr id="row_${row.id}">
                    <td>${index + 1}</td>
                    <td>${row.name ?? ''}</td>
                    <td>${row.category ?? ''}</td>
                    <td>${row.type ?? ''}</td>
                    <td>
                        <div class="dsbdy-filter-wrp p-0 align-items-start">
                            <a href="#url" class="cmn-btn btn-sm flex-shrink-0"
                                style="width: 90px; height: 25px; font-size: 12px; padding: 2px;">
                                Recurring
                            </a>
                        </div>
                    </td>
                    <td>
                        <div class="actions-wrp">
                            ${row.status == 1
                                ? '<span class="cmn-tbl-btn green-bg">Active</span>'
                                : '<span class="cmn-tbl-btn red-bg">Inactive</span>'
                            }
                        </div>
                    </td>
                    <td>
                        <div class="btn-wrp">
                            <button><img src="{{ asset('images/fees/edit-icon-primary.svg') }}" alt="Icon"></button>
                            <button><img src="{{ asset('images/fees/bin-icon.svg') }}" alt="Icon"></button>
                        </div>
                    </td>
                </tr>
            `;
                    });
                })
                .catch(error => console.error('Filter error:', error));
        }








        // search fees-type-row



        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Get data from button
                const id = this.dataset.id;
                const name = this.dataset.name;
                const category = this.dataset.category;
                const description = this.dataset.description;
                const status = this.dataset.status;


                document.getElementById('visitForm').action = `/fees-type/update/${id}`;


                document.getElementById('name').value = name;
                document.getElementById('category').value = category;
                document.getElementById('description').value = description;
                document.getElementById('status').value = status;
            });
        });


        function show_edit_modal(id, name, category, description) {
            document.getElementById('ed_title_name').value = name;
            document.getElementById('ed_category').value = category;
            document.getElementById('ed_description').value = description;
            document.getElementById('edit_fee_id').value = id;

        }


        function deletetypegroup(button) {
            const groupId = button.getAttribute("data-id");



            fetch(`/fees-type/delete/${groupId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json",
                    }
                })
                .then(async response => {
                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || "Failed to delete fees type");
                    }
                    return response.json();
                })
                .then(data => {

                    const row = button.closest("tr");
                    if (row) row.remove();


                })
                .catch(error => {
                    console.error(error);
                    alert("Error: " + error.message);
                });
        }



        // enable/ disable number of installments section in fees-master


        function toggleInstallmentSection() {
            const toggle = document.getElementById("enable-installments");
            const installmentSection = document.querySelector(".number-of-installment");

            installmentSection.style.display = toggle.checked ? "block" : "none";
        }

        // Toggle installment form (auto-split)
        function toggleInstallmentForm() {
            const autoSplitToggle = document.getElementById("auto-split");
            const installmentForm = document.querySelector(".installment-form");
            installmentForm.style.display = autoSplitToggle.checked ? "block" : "none";
        }

        // Generate installment rows dynamically
        function generateInstallmentRows() {
            const input = document.getElementById("installment-count");
            let count = parseInt(input.value, 10) || 0;

            // Enforce min/max
            if (count < 0) count = 0;
            if (count > 5) count = 5;
            input.value = count;

            const container = document.getElementById("installment-rows-container");
            container.innerHTML = ""; // Clear existing rows

            for (let i = 1; i <= count; i++) {
                const row = document.createElement("div");
                row.classList.add("multi-input-grp", "installment-row");
                row.style.marginBottom = "10px";

                row.innerHTML = `
            <div class="input-grp">
                <label>Installment ${i}</label>
                <input type="number" name="installment_amount[]" class="installment-amount"
                    style="width: 184px; position: relative; top: 37px; left: -85px;" required>
            </div>
            <div class="input-grp">
                <label style="position:relative; top:-9px; left:-40px;">Due Date</label>
                <input type="date" name="due_date[]" 
                    style="width: 207px; position:relative; left:-116px; top:28px; height: 50px;" required>
            </div>
            <div class="input-grp">
                <img src="{{ asset('images/fees/bin-icon.svg') }}" 
                     alt="Delete" 
                     style="cursor:pointer;" 
                     onclick="removeInstallmentRow(this)">
            </div>
        `;
                container.appendChild(row);
            }

            autoFillInstallmentAmounts(); // auto-fill after generating rows
        }

        // Auto-fill installment amounts based on total
        function autoFillInstallmentAmounts() {
            const totalAmount = parseFloat(document.getElementById("amount").value) || 0;
            const rows = document.querySelectorAll(".installment-amount");
            if (rows.length === 0 || totalAmount === 0) return;

            const perInstallment = (totalAmount / rows.length).toFixed(2);

            rows.forEach((input, index) => {
                // Last installment adjusted to fix rounding issues
                if (index === rows.length - 1) {
                    const sumPrev = perInstallment * (rows.length - 1);
                    input.value = (totalAmount - sumPrev).toFixed(2);
                } else {
                    input.value = perInstallment;
                }
            });
        }

        // Attach events
        document.getElementById("amount").addEventListener("input", autoFillInstallmentAmounts);
        document.getElementById("installment-count").addEventListener("input", generateInstallmentRows);

        function removeInstallmentRow(el) {
            el.closest(".installment-row").remove();
            autoFillInstallmentAmounts(); // recalc after removal
        }
        // Remove a single installment row and re-number
        function removeInstallmentRow(icon) {
            const row = icon.closest(".multi-input-grp");
            if (row) row.remove();

            // Re-number rows after removal
            const rows = document.querySelectorAll("#installment-rows-container .multi-input-grp");
            rows.forEach((row, index) => {
                const label = row.querySelector("label");
                if (label) label.textContent = `Installment ${index + 1}`;
            });

            // Update count input
            document.getElementById("installment-count").value = rows.length;
        }

        function deletemaster(button) {
            const groupId = button.getAttribute("data-id");



            fetch(`/fees-master/delete/${groupId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json",
                    }
                })
                .then(async response => {
                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || "Failed to delete fees master");
                    }
                    return response.json();
                })
                .then(data => {
                    // remove row from table
                    const row = button.closest("tr");
                    if (row) row.remove();


                })
                .catch(error => {
                    console.error(error);
                    alert("Error: " + error.message);
                });
        }


        // Search Fees Master

        function searchFeesMasters() {
            let query = document.getElementById('searchInput').value;

            fetch(`{{ route('fees-master.search') }}?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('feesMasterTableBody').innerHTML = data.html;
                })
                .catch(error => console.error('Error:', error));
        }


        document.getElementById('searchInput').addEventListener('keyup', function() {
            searchFeesMasters();
        });



        // display summary Review


        document.getElementById("visitForm").addEventListener("submit", function(e) {
            e.preventDefault();

            let form = this;
            let formData = new FormData(form);

            fetch(form.action, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateSummaryReview(data.data); // pass response data to function
                        form.reset();
                    } else {
                        alert(data.message || "Something went wrong!");
                    }
                })
                .catch(error => console.error("Error:", error));
        });

        function updateSummaryReview(data) {
            // Dynamically fill the summary card
            document.querySelector(".dsprprofile-course-info").innerHTML = `
        <table>
            <tr><td>Fees Group:</td><td>${data.fees_group_name}</td></tr>
            <tr><td>Fees Type:</td><td>${data.fees_type_name}</td></tr>
            <tr><td>Total Amount:</td><td>$${data.amount}</td></tr>
            <tr><td>Installments:</td><td>${data.total_installment || 0}</td></tr>
        </table>
        <hr>
        ${data.installments?.length ? `
                        <h4 class="installment-review">Installment Schedule</h4>
                        <table>
                            ${data.installments.map((inst, index) => `
                    <tr>
                        <td>Installment ${index + 1}:</td>
                        <td>$${inst.amount} (Due: ${inst.due_date})</td>
                    </tr>
                `).join("")}
                        </table>
                    ` : ""}
    `;
        }


        function fill_details(id) {
            // Get the selected option text
            let select = document.getElementById(id);
            let selectedText = select.options[select.selectedIndex].text;

            // Update the TD with selected group name
            document.getElementById(id + "_name").innerText = selectedText;
        }


        // filter assets Types




        function filterAssets() {
            const assetType = document.getElementById('assetTypeFilter').value;

            // Make AJAX request to backend route
            fetch(`/dormitory/it-assets?asset_type=${assetType}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    // Replace table body with filtered results
                    document.getElementById('assetsBody').innerHTML = html;
                })
                .catch(error => console.error('Error fetching assets:', error));
        }



        const tabs = document.querySelectorAll('.cmn-tab-head ul li');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active')); // remove active from all
                tab.classList.add('active'); // add active to clicked tab
            });
        });

        function switchTab(element, tableId) {
            const tabBg = document.querySelector(".cmn-tab-head .tab-bg");
            const parent = element.parentElement;
            const rect = element.getBoundingClientRect();
            const parentRect = parent.getBoundingClientRect();
            const filter = document.getElementById("requestStatusFilter");

            // Move tab-bg
            tabBg.style.left = (rect.left - parentRect.left) + "px";
            tabBg.style.width = rect.width + "px";

            // Update active state
            parent.querySelectorAll("li:not(.tab-bg)").forEach(li => li.classList.remove("active"));
            element.classList.add("active");

            // Toggle tables
            document.getElementById("pending-request").style.display = "none";
            document.getElementById("request-status").style.display = "none";



            document.getElementById(tableId).style.display = "table";

            if (tableId === "request-status") {
                filter.style.display = "inline-block";
            } else {
                filter.style.display = "none";
            }
        }

        function toggleTabs() {
            const dropdown = document.getElementById('ParentyearFilter');
            const procurementSection = document.getElementById('procure-section');
            const requestSection = document.getElementById('request-section');
            const approvedSection = document.getElementById('approved-section');
            const fullfillmentSection = document.getElementById('fullfillmentHistory-section');


            if (dropdown.value === 'Procurement Entry') {
                procurementSection.style.display = 'block';
                requestSection.style.display = 'none';
                fullfillmentSection.style.display = 'none';
                approvedSection.style.display = 'none';
            } else if (dropdown.value === 'Approved request') {

                approvedSection.style.display = 'block';
                requestSection.style.display = 'none';
                procurementSection.style.display = 'none';
                fullfillmentSection.style.display = 'none';

            } else if (dropdown.value === 'Fullfillment History') {

                fullfillmentSection.style.display = 'block';
                requestSection.style.display = 'none';
                procurementSection.style.display = 'none';
                approvedSection.style.display = 'none';

            } else {
                requestSection.style.display = 'block';
                procurementSection.style.display = 'none';
                approvedSection.style.display = 'none';
                fullfillmentSection.style.display = 'none';
            }

        }


        function switchstatus() {
            const tabBg = document.querySelector(".cmn-tab-head .tab-bg");
            const parent = element.parentElement;
            const rect = element.getBoundingClientRect();
            const parentRect = parent.getBoundingClientRect();

            // Move tab-bg
            tabBg.style.left = (rect.left - parentRect.left) + "px";
            tabBg.style.width = rect.width + "px";

            // Update active state
            parent.querySelectorAll("li").forEach(li => li.classList.remove("active"));
            element.classList.add("active");

            // Show Export only if Unfilled & not Approved request
            const exportBtn = document.getElementById("exportBtn");
            const dropdown = document.getElementById("ParentyearFilter");
            if (element.textContent.trim() === "Unfilled" && dropdown.value !== "Approved request") {
                exportBtn.style.display = "inline-block";
            } else {
                exportBtn.style.display = "none";
            }
        }

        function RefreshAssets() {
            const selectedType = document.getElementById("assetTypeFilter").value;

            if (selectedType) {
                // Refresh the page
                location.reload();
            }
        }


        // Switch Request

        function switchRequest(clickedTab, tableId) {
            // Remove active class from all tabs
            document.querySelectorAll('.cmn-tab-head ul li').forEach(tab => {
                tab.classList.remove('active');
            });

            // Add active class to clicked tab
            clickedTab.classList.add('active');

            // Hide all tables
            document.querySelectorAll('.ds-cmn-tble table').forEach(table => {
                table.style.display = 'none';
            });

            // Show the selected table
            document.getElementById(tableId).style.display = 'table';
        }





        // filter request



        function filterRequestStatus() {
            const filter = document.getElementById('requestStatusFilter');

            if (!filter) {
                console.error('Filter element not found!');
                return;
            }

            filter.addEventListener('change', function() {
                const selected = this.value;

                fetch(`/dormitory/requested-assets/filter?status=${selected}`)
                    .then(response => response.text())
                    .then(html => {
                        console.log(html);
                        document.getElementById('requeststatusBody').innerHTML = html;
                    })
                    .catch(error => console.error('Error fetching filtered data:', error));
            });
        }

        // Initialize after DOM is loaded
        document.addEventListener('DOMContentLoaded', filterRequestStatus);


        // update request status

        function updateRequestStatus(button, status) {
            const id = button.getAttribute('data-id');

            const url = `/dormitory/requested-assets/update-status/${id}`;

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id: id,
                        status: status
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {

                        location.reload();
                    } else {
                        alert("Something went wrong!");
                    }
                })
                .catch(err => console.error(err));
        }

        // Event listeners
        document.querySelectorAll('.btn-approve').forEach(button => {
            button.addEventListener('click', function() {
                updateRequestStatus(this, 4);
            });
        });

        document.querySelectorAll('.btn-reject').forEach(button => {
            button.addEventListener('click', function() {
                updateRequestStatus(this, 3);
            });
        });

        // view issue report

        document.querySelectorAll('.view-attachment-btn').forEach(button => {
            button.addEventListener('click', function() {
                const title = this.getAttribute('data-title');
                const file = this.getAttribute('data-file');

                // Extract file extension (format)
                const fileExtension = file.split('.').pop().toUpperCase();

                // Build dynamic HTML
                const attachmentHTML = `
            <div class="file-description">
                <div class="header">
                    <p><strong>Title:</strong> ${title}</p>
                    <p><strong>File Format:</strong> ${fileExtension} File</p>
                </div>
                <div class="footer">
                    <a href="/uploads/${file}" download>
                        <button>Download</button>
                    </a>
                </div>
            </div>
        `;

                // Insert into modal container
                document.getElementById('attachmentsContainer').innerHTML = attachmentHTML;
            });
        });



        // search procurement


        function searchProcure(searchbox, table_body) {
            const query = document.getElementById(searchbox).value.trim();

            fetch(`{{ route('procurement.search') }}?q=${encodeURIComponent(query)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    // Replace tbody contents
                    const tbodies = document.querySelectorAll("#" + table_body);
                    tbodies.forEach(tb => tb.innerHTML = html);
                    //document.querySelectorAll("#"+table_body").forEach(tb => tb.innerHTML = html);
                })
                .catch(err => console.error(err));
        }


        // export procurement

        function exportRequestStatusTable() {
            const table = document.getElementById("request-status"); // only second table
            let csv = [];
            const rows = table.querySelectorAll("tr");

            rows.forEach(row => {
                const cols = row.querySelectorAll("th, td");
                const rowData = [];
                cols.forEach(col => {
                    // Escape double quotes
                    let data = col.innerText.replace(/"/g, '""');
                    rowData.push('"' + data + '"');
                });
                csv.push(rowData.join(","));
            });

            // Create CSV file
            const csvFile = new Blob([csv.join("\n")], {
                type: "text/csv"
            });

            // Create temporary link to trigger download
            const downloadLink = document.createElement("a");
            downloadLink.download = "request_status_data.csv"; // file name
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = "none";

            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }

        // Attach onclick event to export button
        document.getElementById("exportBtn").onclick = exportRequestStatusTable;

        // filter procurement by user name

        function filterRequestsByUser() {
            const staffId = document.getElementById('userFilter').value;

            fetch(`{{ route('procurement.filter') }}?staff_id=${staffId}`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('fullfillmentHistoryBody');
                    tbody.innerHTML = ''; // Clear table

                    if (data.requests.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="9" style="text-align:center;">No records found</td></tr>`;
                        return;
                    }

                    data.requests.forEach((req, index) => {
                        const row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${req.id}</td>
                        <td>${req.staff_name ?? '—'}</td>
                        <td>${req.staff_id ?? '—'}</td>
                        <td>${req.asset_name ?? 'Unknown'}</td>
                        <td>${req.asset_model ?? 'N/A'}</td>
                        <td>${req.quantity}</td>
                        <td>${req.quantity}</td>
                        <td>${new Date(req.created_at).toLocaleDateString('en-GB')}</td>
                    </tr>`;
                        tbody.insertAdjacentHTML('beforeend', row);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // 🔹 Attach event listener
        document.getElementById('userFilter').addEventListener('change', function() {
            const selectedUser = this.value;
            fetchRequestsByUser(selectedUser);
        });

        // 🔹 Optionally load all requests on page load
        document.addEventListener('DOMContentLoaded', function() {
            fetchRequestsByUser('');
        });


        // filter procurement by date

        function filterByDeliveryDate() {
            const selectedDate = document.getElementById('deliveryDateFilter').value;

            fetch(`{{ route('procurement.filterByDate') }}?date=${selectedDate}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('fullfillmentHistoryBody').innerHTML = data.html;
                })
                .catch(error => {
                    console.error('Error filtering data:', error);
                });
        }


        // mantainance make as done

        function markAsDone(id) {


            fetch(`{{ route('maintenance.markDone', '') }}/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        location.reload();

                        const row = document.querySelector(`#row-${id}`);
                        const statusCell = row.querySelector('td:nth-child(6)');
                        const actionCell = row.querySelector('td:nth-child(7)');


                        statusCell.innerHTML =
                            `<button style="background-color:green; color:white; padding:4px; font-size:14px;">Resolved</button>`;

                        actionCell.innerHTML = `<span style="color:gray;">✔ Done</span>`;


                        document.querySelector('#resolvedBody').appendChild(row);

                    } else {
                        alert('Failed to update. Try again.');
                    }
                })
                .catch(err => console.error('Error:', err));
        }



        // download table in mantainance




        function exportVisibleTable() {
            let table;
            let fileName;

            // Detect which table is visible
            const pendingTable = document.getElementById("pending-request");
            const resolvedTable = document.getElementById("request-status");

            if (pendingTable && pendingTable.style.display !== "none") {
                table = pendingTable;
                fileName = "pending_requests.csv";
            } else if (resolvedTable && resolvedTable.style.display !== "none") {
                table = resolvedTable;
                fileName = "resolved_requests.csv";
            } else {
                alert("No visible table found to export.");
                return;
            }

            // Convert table to CSV
            let csv = [];
            const rows = table.querySelectorAll("tr");

            rows.forEach(row => {
                const cols = row.querySelectorAll("th, td");
                const rowData = [];
                cols.forEach(col => {
                    // Escape double quotes for CSV formatting
                    let data = col.innerText.replace(/"/g, '""');
                    rowData.push('"' + data + '"');
                });
                csv.push(rowData.join(","));
            });

            // Create CSV blob
            const csvFile = new Blob([csv.join("\n")], {
                type: "text/csv"
            });

            // Create download link
            const downloadLink = document.createElement("a");
            downloadLink.download = fileName;
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = "none";

            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }


        function filterByroomMentainence() {

            // const search = document.getElementById('searchInput').value;
            const room = document.getElementById('room_id').value;

            window.location.href = "{{ route('maintenance.filterByroom') }}" + "?room_no=" + encodeURIComponent(room);
            fetch("{{ route('maintenance.filterByroom') }}?room_no=" + encodeURIComponent(room))
                .then(response => response.json())
                .then(data => {
                    document.getElementById('pending-request').innerHTML = data.pendingHtml;
                    document.getElementById('request-status').innerHTML = data.resolvedHtml;
                })
                .catch(error => {
                    console.error('Error fetching filtered data:', error);
                });
        }


        // filter mantainence on basis of issue date

        function filterByIssueDate() {
            const issueDate = document.getElementById('filter_date').value;
            if (!issueDate) return;

            // Detect which table is currently visible
            const isPendingVisible = document.getElementById('pending-request').style.display !== 'none';
            const status = isPendingVisible ? 0 : 1; // 0 = Pending, 1 = Resolved

            fetch("{{ route('maintenance.filterByIssueDate') }}?issue_date=" + encodeURIComponent(issueDate) + "&status=" +
                    status)
                .then(response => response.json())
                .then(data => {
                    if (status === 0) {
                        document.querySelector('#pending-request tbody').innerHTML = data.pendingHtml;
                    } else {
                        document.querySelector('#request-status tbody').innerHTML = data.resolvedHtml;
                    }
                })
                .catch(error => {
                    console.error('Error filtering data:', error);
                });
        }

        function exportVisibleLateTable() {
            let table;
            let fileName;

            // Detect which table is visible
            const pendingTable = document.getElementById("pending-request");
            const resolvedTable = document.getElementById("request-status");

            if (pendingTable && pendingTable.style.display !== "none") {
                table = pendingTable;
                fileName = "admin_requests.csv";
            } else if (resolvedTable && resolvedTable.style.display !== "none") {
                table = resolvedTable;
                fileName = "student_requests.csv";
            } else {
                alert("No visible table found to export.");
                return;
            }

            // Convert table to CSV
            let csv = [];
            const rows = table.querySelectorAll("tr");

            rows.forEach(row => {
                const cols = row.querySelectorAll("th, td");
                const rowData = [];
                cols.forEach(col => {
                    // Escape double quotes for CSV formatting
                    let data = col.innerText.replace(/"/g, '""');
                    rowData.push('"' + data + '"');
                });
                csv.push(rowData.join(","));
            });

            // Create CSV blob
            const csvFile = new Blob([csv.join("\n")], {
                type: "text/csv"
            });

            // Create download link
            const downloadLink = document.createElement("a");
            downloadLink.download = fileName;
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = "none";

            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }


        // autofill student id in late curfew

        function handleStudentSelect() {
            const studentSelect = document.getElementById('student_name_select');
            const studentIdField = document.getElementById('student_id_field');
            const roomField = document.getElementById('room_field');

            const selectedId = studentSelect.value;
            studentIdField.value = selectedId || '';
            roomField.value = ''; // reset room field

            if (!selectedId) return;


            fetch(`late-entry/get-student-room?student_id=${selectedId}`)
                .then(response => response.json())
                .then(data => {
                    roomField.value = data.room || 'No room found';
                })
                .catch(error => {
                    console.error('Error fetching room:', error);
                    roomField.value = 'Error fetching room';
                });
        }



        // filter late curfew entry by room

        function filterByRoomLate() {
            const selectedRoom = document.getElementById('room_id').value;

            fetch(`{{ route('latecurfew.filterByroom') }}?room_id=${selectedRoom}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    const tbody = document.getElementById('latecurfewBody');
                    tbody.innerHTML = ''; // clear old rows

                    if (data.entries.length > 0) {
                        data.entries.forEach((entry, index) => {
                            tbody.innerHTML += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${entry.date || ''}</td>
                            <td>${entry.time || ''}</td>
                            <td>${entry.student_name || ''}</td>
                            <td>${entry.room || ''}</td>
                            <td>${entry.reason || ''}</td>
                        </tr>
                    `;
                        });
                    } else {
                        tbody.innerHTML = `<tr><td colspan="6" class="text-center">No records found</td></tr>`;
                    }
                })
                .catch(err => console.error('Error fetching room data:', err));
        }


        // filter by student name late curfew

        function filterByStudentLate() {
            const selectedStudent = document.getElementById('student_id').value;

            fetch(`{{ route('latecurfew.filterBystudentname') }}?student_id=${selectedStudent}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    const tbody = document.getElementById('latecurfewBody');
                    tbody.innerHTML = '';

                    if (data.entries.length > 0) {
                        data.entries.forEach((entry, index) => {
                            tbody.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${entry.date || ''}</td>
                        <td>${entry.time || ''}</td>
                        <td>${entry.student_name || ''}</td>
                        <td>${entry.room || ''}</td>
                        <td>${entry.reason || ''}</td>
                    </tr>
                `;
                        });
                    } else {
                        tbody.innerHTML = `<tr><td colspan="6" class="text-center">No records found</td></tr>`;
                    }
                })
                .catch(err => console.error('Error fetching student data:', err));
        }


        // filter by date on late curfew 

        function filterByDateLate() {
            // console.log("testing");
            const selectedDate = document.getElementById('filter_date').value;

            fetch(`{{ route('latecurfew.filterByDateLate') }}?date=${selectedDate}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    const tbody = document.getElementById('latecurfewBody');
                    tbody.innerHTML = '';

                    if (data.entries.length > 0) {
                        data.entries.forEach((entry, index) => {
                            tbody.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${entry.date || ''}</td>
                        <td>${entry.time || ''}</td>
                        <td>${entry.student_name || ''}</td>
                        <td>${entry.room || ''}</td>
                        <td>${entry.reason || ''}</td>
                    </tr>
                `;
                        });
                    } else {
                        tbody.innerHTML = `<tr><td colspan="6" class="text-center">No records found</td></tr>`;
                    }
                })
                .catch(err => console.error('Error fetching date filter data:', err));
        }



        // toggle read more 

        function toggleReadMore(element) {
            const td = element.closest('td');
            const shortText = td.querySelector('.short-text');
            const fullText = td.querySelector('.full-text');

            if (fullText.style.display === 'none') {
                fullText.style.display = 'inline';
                shortText.style.display = 'none';
                element.textContent = 'Show less';
            } else {
                fullText.style.display = 'none';
                shortText.style.display = 'inline';
                element.textContent = 'Read more';
            }
        }


        // handle student id select

        function handleStudentIdSelect() {
            const select = document.getElementById('student_id_doctor');
            const nameField = document.getElementById('student_name_doctor');

            const selectedOption = select.options[select.selectedIndex];
            const studentName = selectedOption.getAttribute('data-name');

            // Set student name in the input
            nameField.value = studentName || '';
        }



        // export doctor table

        function exportDoctorTable() {
            let table;
            let fileName;

            // Detect which table is visible
            const pendingTable = document.getElementById("pending-request");
            const resolvedTable = document.getElementById("request-status");

            if (pendingTable && pendingTable.style.display !== "none") {
                table = pendingTable;
                fileName = "doctors_data.csv";
            } else if (resolvedTable && resolvedTable.style.display !== "none") {
                table = resolvedTable;
                fileName = "student_requests.csv";
            } else {
                alert("No visible table found to export.");
                return;
            }

            // Convert table to CSV
            let csv = [];
            const rows = table.querySelectorAll("tr");

            rows.forEach(row => {
                const cols = row.querySelectorAll("th, td");
                const rowData = [];
                cols.forEach(col => {
                    // Escape double quotes for CSV formatting
                    let data = col.innerText.replace(/"/g, '""');
                    rowData.push('"' + data + '"');
                });
                csv.push(rowData.join(","));
            });

            // Create CSV blob
            const csvFile = new Blob([csv.join("\n")], {
                type: "text/csv"
            });

            // Create download link
            const downloadLink = document.createElement("a");
            downloadLink.download = fileName;
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = "none";

            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);

        }



        // filter doctor data by student id

function filterByStudentIdDoctor() {
    const selectedStudent = document.getElementById('student_id').value;

    // Build the URL dynamically (same route as page load)
    let url = "{{ route('doctorVisit.filterdoctordatabystudentId') }}";
    if (selectedStudent) {
        url += `?student_id=${selectedStudent}`;
    }

    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        const tbody = document.getElementById('doctorsDataBody');
        tbody.innerHTML = '';

        if (data.doctors && data.doctors.length > 0) {
            data.doctors.forEach((doctor, index) => {
                tbody.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${doctor.entry_date ?? ''}</td>
                        <td>${doctor.student_id ?? ''}</td>
                        <td>${doctor.name ?? ''}</td>
                        <td>${doctor.description ?? ''}</td>
                        <td>${doctor.issue ?? ''}</td>
                    </tr>
                `;
            });
        } else {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center">No records found</td></tr>`;
        }
    })
    .catch(err => console.error('Error fetching student data:', err));
}


function filterByDateDoctor(){
        const selectedDate = document.getElementById('filter_dateDoctor').value;

            fetch(`{{ route('doctorVisit.filterdoctordatabyDate') }}?entry_date=${selectedDate}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    const tbody = document.getElementById('doctorsDataBody');
                    tbody.innerHTML = '';

                if (data.doctors && data.doctors.length > 0) {
            data.doctors.forEach((doctor, index) => {
                tbody.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${doctor.entry_date ?? ''}</td>
                        <td>${doctor.student_id ?? ''}</td>
                        <td>${doctor.name ?? ''}</td>
                        <td>${doctor.description ?? ''}</td>
                        <td>${doctor.issue ?? ''}</td>
                    </tr>
                `;
            });
        } else {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center">No records found</td></tr>`;
        }
                })
                .catch(err => console.error('Error fetching date filter data:', err));
}


// export inventory table

        function exportVisibleLateTable() {
            let table;
            let fileName;

            // Detect which table is visible
            const pendingTable = document.getElementById("pending-request");
            const resolvedTable = document.getElementById("request-status");

            if (pendingTable && pendingTable.style.display !== "none") {
                table = pendingTable;
                fileName = "inventory_list.csv";
            } else if (resolvedTable && resolvedTable.style.display !== "none") {
                table = resolvedTable;
                fileName = "student_requests.csv";
            } else {
                alert("No visible table found to export.");
                return;
            }

            // Convert table to CSV
            let csv = [];
            const rows = table.querySelectorAll("tr");

            rows.forEach(row => {
                const cols = row.querySelectorAll("th, td");
                const rowData = [];
                cols.forEach(col => {
                    // Escape double quotes for CSV formatting
                    let data = col.innerText.replace(/"/g, '""');
                    rowData.push('"' + data + '"');
                });
                csv.push(rowData.join(","));
            });

            // Create CSV blob
            const csvFile = new Blob([csv.join("\n")], {
                type: "text/csv"
            });

            // Create download link
            const downloadLink = document.createElement("a");
            downloadLink.download = fileName;
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = "none";

            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"
        integrity="sha512-bE2H3X0bwh9k4EStk1gE5X01gA6Y+/C75OHyJDq4RVlM1aFzDJgcZlcpJKuFVZ0Y99D7eM6nE+EZ0zKfL6+5MA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>

</html>
