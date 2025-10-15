document.addEventListener('DOMContentLoaded', function () {

    jQuery(document).ready(function ($) {
        // document start


        $("<span class='clickD'></span>").insertAfter(".navbar-nav li.menu-item-has-children > a");
        $('.navbar-nav').on('click', 'li .clickD', function (e) {
            e.preventDefault();
            const $this = $(this);
            const $subs = $this.closest('ul').find('.sub-menu, .clickD').not($this.next());
            $subs.removeClass('show toggled');
            $this.next().toggleClass('show');
            $this.toggleClass('toggled');
        });
        $(window).on('resize load', function () {
            if ($(this).width() < 1025) {
                $('html, body').off('click.outer').on('click.outer', function () {
                    $('.navbar-nav .sub-menu, .navbar-nav .clickD').removeClass('show toggled');
                });
                $('.navbar-nav').off('click.inner').on('click.inner', function (e) {
                    e.stopPropagation();
                });
            } else {
                $('html, body').off('click.outer');
                $('.navbar-nav').off('click.inner');
            }
        });

        // Hamburger animation
        $(".navbar-toggler").on('click', function () {
            $(this).toggleClass("open").find('.stick').toggleClass("open");
            $('body, html').toggleClass("open-nav");
        });

        // Tab switching for login
        const $tabs = $('[role="tab"]');
        const $heading = $(".login-heading");
        const $form = $("#login-form");
        if ($form.length) {
            $tabs.on('click', function () {
                $tabs.attr({ 'aria-selected': 'false', tabindex: '-1' }).removeClass('active');
                $(this).attr({ 'aria-selected': 'true' }).removeAttr('tabindex').addClass('active');
                const titles = {
                    'tab-student': 'User Login',
                    'tab-parent': 'Parent Login',
                    'tab-alumni': 'Alumni Login'
                };
                $heading.text(titles[this.id] || $heading.text());
            });

            // Password show/hide
            $('.password-wrapper').each(function () {
                const $w = $(this);
                const $input = $w.find('.password-field');
                const $toggle = $w.find('.toggle-password-visibility');
                const $icon = $toggle.find('img');
                $toggle.on('click', function () {
                    const isPwd = $input.attr('type') === 'password';
                    $input.attr('type', isPwd ? 'text' : 'password');
                    // $icon.attr('src', isPwd ? './images/eye-open.svg' : './images/eye-close.svg');
                    $icon.attr('src', isPwd 
                        ? "/backend/assets/images/new_images/eye-open.svg" 
                        : "/backend/assets/images/new_images/eye-close.svg"
                    );
                    $toggle.attr('aria-label', isPwd ? 'Hide password' : 'Show password');
                });
            });
        }

        // Sidebar toggle
        $('#sidebarToggle').on('click', function () {
            $('#sidebar, #main-content').toggleClass('collapsed expanded');
            $(this).toggleClass('fa-chevron-left fa-chevron-right');
        });

        // User profile dropdown
        $('#userProfile').on('click', function (e) {
            e.stopPropagation();
            $(this).toggleClass('open');
        });
        $(document).on('click', function () {
            $('#userProfile').removeClass('open');
        });

        // OTP inputs
        $('.otp-container input').each(function (i, input) {
            $(input).on({
                input(e) {
                    this.value = this.value.replace(/\D/g, '');
                    if (this.value && i < $('.otp-container input').length - 1)
                        $('.otp-container input').eq(i + 1).focus();
                },
                keydown(e) {
                    if (e.key === 'Backspace' && !this.value && i > 0)
                        $('.otp-container input').eq(i - 1).focus();
                },
                focus() { this.select(); }
            });
        });

        // Datepicker
        if ($('.datepicker').length) {
            const yearSel = $('#year-select'),
                monthSel = $('#month-select'),
                weekSel = $('#week-select'),
                rangeDisp = $('#range-display'),
                now = new Date(),
                currentY = now.getFullYear(),
                monthNames = [
                    "January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ];

            for (let y = currentY - 5; y <= currentY + 5; y++)
                yearSel.append(new Option(y, y));
            monthNames.forEach((m, i) => monthSel.append(new Option(m, i)));

            function updateWeeks() {
                weekSel.empty();
                const year = +yearSel.val(), month = +monthSel.val();
                const daysInMonth = new Date(year, month + 1, 0).getDate();
                for (let start = 1; start <= daysInMonth; start += 6) {
                    const end = Math.min(start + 5, daysInMonth);
                    const fmt = d => `${String(d.getDate()).padStart(2, '0')} ${monthNames[d.getMonth()].slice(0, 3)}`;
                    weekSel.append(new Option(`${fmt(new Date(year, month, start))} – ${fmt(new Date(year, month, end))}`, `${start}-${end}`));
                }
                updateRange();
            }
            function updateRange() {
                const [s, e] = weekSel.val().split('-').map(Number);
                const sD = new Date(yearSel.val(), monthSel.val(), s);
                const eD = new Date(yearSel.val(), monthSel.val(), e);
                const fullFmt = d => `${monthNames[d.getMonth()].slice(0, 3)} ${String(d.getDate()).padStart(2, '0')}, ${d.getFullYear()}`;
                rangeDisp.text(`${fullFmt(sD)} – ${fullFmt(eD)}`);
            }
            yearSel.add(monthSel).on('change', updateWeeks);
            weekSel.on('change', updateRange);
            $('#btn-cancel').on('click', e => { e.preventDefault(); updateWeeks(); });
            $('#btn-apply').on('click', e => { e.preventDefault(); alert('You picked: ' + rangeDisp.text()); });

            yearSel.val(currentY);
            monthSel.val(now.getMonth());
            updateWeeks();
        }

        // Escape HTML helper
        const escapeHTML = str => str.replace(/[&<>"]/g, c =>
            ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c])
        );

        // Toggle text (“Read more”)
        function initToggleText() {
            $('.toggle-text-content').each(function () {
                const $c = $(this), full = $c.text().trim();
                $c.css({ width: '100%', height: '', overflow: '' }).removeClass('expanded');
                const lh = parseFloat($c.css('line-height')), maxH = lh * 2;
                let lo = 0, hi = full.length, best = 0;
                while (lo <= hi) {
                    const mid = Math.floor((lo + hi) / 2);
                    $c.html(escapeHTML(full.slice(0, mid / 2.5)) + '… <a href="#" class="read-more">Read more <i class="fa-solid fa-arrow-right" style="transform:rotate(-45deg)"></i></a>');
                    if ($c[0].offsetHeight <= maxH) { best = mid; lo = mid + 1; }
                    else { hi = mid - 1; }
                }
                $c.html(escapeHTML(full.slice(0, best)) + '… <a href="#" class="read-more">Read more <i class="fa-solid fa-arrow-right" style="transform:rotate(-45deg)"></i></a>')
                    .css({ height: maxH + 'px', overflow: 'hidden' });
            });
            $('.toggle-text-wrapper').off('click.readmore').on('click.readmore', '.read-more', function (e) {
                e.preventDefault();
                const $c = $(this).closest('.toggle-text-wrapper').find('.toggle-text-content');
                const full = $c.data('full') || ($c.data('full', $c.text()), $c.data('full'));
                const expanded = $c.toggleClass('expanded').hasClass('expanded');
                if (expanded) {
                    $c.html(escapeHTML(full) + ' <a href="#" class="read-more expanded">Show less <i class="fa-solid fa-arrow-right"></i></a>')
                        .css({ height: 'auto', overflow: '' });
                } else {
                    initToggleText(); // re-run to recalculate
                }
            });
        }

        function initTabs() {
            $('.tab-wrapper').each(function () {
                const $wrapper = $(this);
                const $tabs = $wrapper.find('.cmn-tab-head ul li').not('.tab-bg');
                const $bg = $wrapper.find('.tab-bg');
                const $tables = $wrapper.find('.ds-cmn-tble');
                const $contents = $wrapper.find('.cmn-tab-content');

                $(".view-attachment-btn").on("click", function () {
                    setTimeout(() => {
                        updateTabBg();
                    }, 200);
                });
                $tabs.each(function (i) {
                    const slug = $(this).text().trim().replace(/[\\/]/g, '').replace(/\s+/g, '-').replace(/[^\w-]/g, '').replace(/-+/g, '-').toLowerCase();
                    $(this).attr('data-filter', '.' + slug);
                    $tables.eq(i).addClass(slug);
                    $contents.eq(i).addClass(slug);
                });
                function updateTabBg() {
                    const $active = $tabs.filter('.active');
                    $bg.css({ left: $active.position().left, top: $active.position().top, width: $active.outerWidth(), height: $active.outerHeight() });
                }

                $tabs.removeClass('active').first().addClass('active');
                $tables.hide().removeClass('active').first().show().addClass('active');
                $contents.hide().removeClass('active').first().show().addClass('active');
                updateTabBg();


                // click handler
                $tabs.on('click', function () {
                    const $t = $(this);
                    const filter = $t.attr('data-filter');
                    $tabs.removeClass('active');
                    $t.addClass('active');
                    updateTabBg();
                    $tables.filter('.active').removeClass('active').fadeOut(300);
                    $contents.filter('.active').removeClass('active').fadeOut(300);
                    $tables.filter(filter).addClass('active').fadeIn(300);
                    $contents.filter(filter).addClass('active').fadeIn(300);
                    setTimeout(initToggleText, 350);
                });
            });
        }

        initToggleText();
        initTabs();
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', initToggleText);

        // Generic dropdowns
        function closeAllMenus() {
            document.querySelectorAll('.dropdown-menu').forEach(m => m.style.display = 'none');
        }
        document.querySelectorAll('.dropdown').forEach(drop => {
            const btn = drop.querySelector('.dropdown-toggle'), menu = drop.querySelector('.dropdown-menu');
            btn.addEventListener('click', e => {
                e.stopPropagation();
                const open = menu.style.display === 'block';
                closeAllMenus();
                menu.style.display = open ? 'none' : 'block';
            });
            menu.addEventListener('click', e => e.stopPropagation());
        });
        document.addEventListener('click', closeAllMenus);
        document.querySelectorAll('.subject-dropdown input[type="checkbox"]').forEach(cb =>
            cb.addEventListener('change', () => {
                const labels = Array.from(document.querySelectorAll('.subject-dropdown input:checked'))
                    .map(i => i.parentNode.textContent.trim());
                document.querySelector('.subject-dropdown .label').textContent =
                    labels.length ? labels.join(', ') : 'Select Subject';
            })
        );


        const dateDrop = document.querySelector('.date-dropdown');
        if (dateDrop) {
            const dateLabel = dateDrop.querySelector('.dropdown-toggle .label');
            const yearSel = dateDrop.querySelector('.year-select');
            const monSel = dateDrop.querySelector('.month-select');

            dateDrop.querySelector('.btn-cancel').addEventListener('click', e => {
                e.stopPropagation();
                closeAllMenus();
            });

            dateDrop.querySelector('.btn-apply').addEventListener('click', e => {
                e.stopPropagation();
                const monthNames = [
                    "January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ];
                const selectedMonth = monthNames[monSel.selectedIndex];
                const selectedYear = yearSel.value;
                dateLabel.textContent = `${selectedMonth}, ${selectedYear}`;
                closeAllMenus();
            });
        }


        const input = document.querySelector('.dest');
        const list = document.querySelector('.dest-list');
        const wrapper = document.querySelector('.dist-list-wrp');
        if (input || list || wrapper) {
            setInterval(() => {
                if (input.value == "") {
                    $(".paylink").hide();
                } else {
                    $(".paylink").show()
                }
            }, 200);
            const data = [
                'Lorem ipsum dolor sit amet',
                'Lorem ipsum dolor sit amet 2',
                'Lorem ipsum dolor sit amet 3',
                'Lorem ipsum dolor sit amet 4',
                'Lorem ipsum dolor sit amet 5'
            ];
            function render(items) {
                list.innerHTML = '';
                if (items.length === 0) {
                    list.hidden = true;
                    wrapper.classList.remove('has-items');
                    return;
                }
                items.forEach(text => {
                    const item = document.createElement('div');
                    item.className = 'autocomplete-item';
                    item.textContent = text;
                    item.addEventListener('click', () => {
                        input.value = text;
                        list.hidden = true;
                        wrapper.classList.remove('has-items');


                    });
                    list.appendChild(item);
                });
                list.hidden = false;
                wrapper.classList.add('has-items');
            }

            input.addEventListener('input', () => {
                const val = input.value.trim().toLowerCase();
                render(
                    val
                        ? data.filter(item => item.toLowerCase().includes(val))
                        : data
                );
            });

            document.addEventListener('click', e => {
                if (!e.target.closest('.autocomplete-list')) {
                    list.hidden = true;
                    wrapper.classList.remove('has-items');
                }
            });
        }


        const btns = document.querySelectorAll('.ibtn');
        btns.forEach(btn => {
            if (btn) {
                const icon = btn.querySelector('.ibtn-icon');
                const notice = btn.querySelector('.ibtn-info');
                const closeBtn = btn.querySelector('.ibtn-close');
                icon.addEventListener('click', e => {
                    e.preventDefault();
                    notice.classList.add('show');
                });
                closeBtn.addEventListener('click', e => {
                    e.stopPropagation();
                    notice.classList.remove('show');
                });
            }
        });


        const sidebarToggler = document.querySelector(".sidebar-toggler");
        if (sidebarToggler) {
            const dashBody = document.querySelector(".dashboard-main");

            sidebarToggler.addEventListener("click", (e) => {
                dashBody.classList.toggle("active");
                e.currentTarget.parentElement.parentElement.classList.toggle("active");
            });
        }

        const hasInfoLinks = document.querySelectorAll(".has-info-card a");
        const body = document.body;

        hasInfoLinks.forEach((link) => {
            link.addEventListener("click", (e) => {
                e.preventDefault();
                body.classList.add("no-scroll");
                const card = link.closest(".has-info-card").querySelector(".notice-info-wrp");
                card.classList.toggle("active");
            });
            const closeBtn = link.closest(".has-info-card").querySelector(".notice-info-wrp .notice-btn-close");
            if (closeBtn) {
                closeBtn.addEventListener("click", (e) => {
                    e.preventDefault();
                    body.classList.remove("no-scroll");
                    const card = e.currentTarget.closest(".notice-info-wrp");
                    card.classList.remove("active");
                });
            }
        });

    });

    const pageRefreshBtn = document.querySelector('.page-refresh-btn');
    if (pageRefreshBtn) {
        pageRefreshBtn.addEventListener('click', e => {
            e.preventDefault();
            window.location.reload();
        });
    }

    if (document.querySelector(".has-drpdn")) {
        document.querySelectorAll('.dropdown-year, .dropdown-period').forEach(drop => {
            const trigger = drop.querySelector('.dropdown-trigger')
            const options = drop.querySelector('.dropdown-options')
            const label = drop.querySelector('.dropdown-label')
            trigger.addEventListener('click', e => {
                e.stopPropagation()
                document.querySelectorAll('.dropdown-year.open, .dropdown-period.open')
                    .forEach(o => { if (o !== drop) o.classList.remove('open') })
                drop.classList.toggle('open')
            })
            options.querySelectorAll('.dropdown-option').forEach(opt => {
                opt.addEventListener('click', () => {
                    label.textContent = opt.textContent
                    drop.dataset.selected = opt.textContent
                    drop.classList.remove('open')
                })
            })
        })
        document.addEventListener('click', () => {
            document.querySelectorAll('.dropdown-year.open, .dropdown-period.open').forEach(d => d.classList.remove('open'))
        })
    }

    if ($('input[name="dates"]').length) {
        $('input[name="dates"]').daterangepicker();
    }

    // Document End

    // DORMITORY

    $(document).ready(function () {
        $('.sidebar-dropdown-btn').click(function () {
            $(".sidebar-dropdown-btn").not(this).removeClass('active');
            $(this).toggleClass('active');
            $(".sidebar-dropdown").not($(this).parent().find(".sidebar-dropdown").slideToggle('fast')).slideUp();
            event.stopPropagation();
        });
    });

    document.addEventListener("click", function (event) {
        if (!event.target.closest(".value-control")) return;

        const button = event.target.closest(".value-control");
        const group = button.closest(".input-number-grp");
        const input = group.querySelector(".value-input");

        if (button.dataset.action === "increase") {
            input.stepUp();
        } else if (button.dataset.action === "decrease") {
            input.stepDown();
        }
    });

    // DROPDOWN-WITH-TAG
    document.querySelectorAll('.dropdown-container').forEach(dropdown => {
        const tagBox = dropdown.querySelector('.selected-tags');
        const tagsWrapper = dropdown.querySelector('.tags-wrapper');
        const dropdownList = dropdown.querySelector('.dropdown-list');
        const arrow = dropdown.querySelector('.arrow');
        const checkboxes = dropdownList.querySelectorAll('input[type="checkbox"]');

        // Toggle dropdown
        tagBox.addEventListener('click', () => {
            const isOpen = dropdownList.style.display === 'block';

            // Close all dropdowns first
            document.querySelectorAll('.dropdown-list').forEach(list => list.style.display = 'none');
            document.querySelectorAll('.arrow').forEach(a => a.classList.remove('open'));

            dropdownList.style.display = isOpen ? 'none' : 'block';
            if (!isOpen) arrow.classList.add('open');
        });

        // Add/remove tags
        checkboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                if (cb.checked) {
                    addTag(cb.value);
                } else {
                    removeTag(cb.value);
                }
                updatePlaceholder();
            });
        });

        function addTag(value) {
            if ([...tagsWrapper.children].some(tag => tag.dataset && tag.dataset.value === value)) return;
            tagsWrapper.querySelector('.plchldr')?.remove();

            const tag = document.createElement('div');
            tag.className = 'tag';
            tag.dataset.value = value;
            tag.innerHTML = `${value} <span class="remove" data-value="${value}">&times;</span>`;
            tagsWrapper.appendChild(tag);

            tag.querySelector('.remove').addEventListener('click', (e) => {
                e.stopPropagation();
                removeTag(value);
                checkboxes.forEach(cb => {
                    if (cb.value === value) cb.checked = false;
                });
                updatePlaceholder();
            });
        }

        function removeTag(value) {
            [...tagsWrapper.children].forEach(tag => {
                if (tag.dataset && tag.dataset.value === value) tag.remove();
            });
        }

        function updatePlaceholder() {
            if (tagsWrapper.children.length === 0) {
                tagsWrapper.innerHTML = `<span class="plchldr">Asset ID</span>`;
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.dropdown-container')) {
                dropdownList.style.display = 'none';
                arrow.classList.remove('open');
            }
        });
    });
    // DROPDOWN-WITH-TAG

    // DORMITORY

});

document.querySelectorAll(".tab-btn").forEach(tab => {
    tab.addEventListener("click", function() {
      // remove active from all tabs
      document.querySelectorAll(".tab-btn").forEach(t => t.classList.remove("active"));
      // remove active from all tables
      document.querySelectorAll(".tab-content").forEach(c => c.classList.remove("active"));

      // activate clicked tab
      this.classList.add("active");
      // show related table
      document.getElementById(this.dataset.target).classList.add("active");
    });
  });

function toggleRoomDropdown() {
  const menu = document.getElementById("dropdownRoomMenu");
  menu.style.display = (menu.style.display === "block") ? "none" : "block";
}
function selectRoomOption(value) {
  document.getElementById("dropdownRoomText").textContent = value;
  document.getElementById("dropdownRoomMenu").style.display = "none";
}

function toggleStuDropdown() {
  const menu = document.getElementById("dropdownStuMenu");
  menu.style.display = (menu.style.display === "block") ? "none" : "block";
}
function selectStuOption(value) {
  document.getElementById("dropdownStuText").textContent = value;
  document.getElementById("dropdownStuMenu").style.display = "none";
}