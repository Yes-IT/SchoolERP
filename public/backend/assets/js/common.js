document.addEventListener('DOMContentLoaded', function () {
    jQuery(document).ready(function ($) {
        // document start

        $("<span class='clickD'></span>").insertAfter(
        ".navbar-nav li.menu-item-has-children > a"
        );
        $(".navbar-nav").on("click", "li .clickD", function (e) {
        e.preventDefault();
        const $this = $(this);
        const $subs = $this
            .closest("ul")
            .find(".sub-menu, .clickD")
            .not($this.next());
        $subs.removeClass("show toggled");
        $this.next().toggleClass("show");
        $this.toggleClass("toggled");
        });
        $(window).on("resize load", function () {
        if ($(this).width() < 1025) {
            $("html, body")
            .off("click.outer")
            .on("click.outer", function () {
                $(".navbar-nav .sub-menu, .navbar-nav .clickD").removeClass(
                "show toggled"
                );
            });
            $(".navbar-nav")
            .off("click.inner")
            .on("click.inner", function (e) {
                e.stopPropagation();
            });
        } else {
            $("html, body").off("click.outer");
            $(".navbar-nav").off("click.inner");
        }
        });

        $(".navbar-toggler").on("click", function () {
        $(this).toggleClass("open").find(".stick").toggleClass("open");
        $("body, html").toggleClass("open-nav");
        });
        const $tabs = $('[role="tab"]');
        const $heading = $(".login-heading");
        const $form = $("#login-form");

        function updateHeading() {
        const $activeTab = $tabs.filter(".active");
        if ($activeTab.length) {
            $heading.text($activeTab.text().trim());
        }
        }

        if ($form.length) {
        $tabs.on("click", function () {
            $tabs
            .attr({"aria-selected": "false", tabindex: "-1"})
            .removeClass("active");
            $(this)
            .attr({"aria-selected": "true"})
            .removeAttr("tabindex")
            .addClass("active");
            updateHeading();
        });
        updateHeading();
        }

        $(".password-wrapper").each(function () {
        const $w = $(this);
        const $input = $w.find(".password-field");
        const $toggle = $w.find(".toggle-password-visibility");
        const $icon = $toggle.find("i");
        $toggle.on("click", function () {
            const isPwd = $input.attr("type") === "password";
            $input.attr("type", isPwd ? "text" : "password");
            $icon.toggleClass("fa-eye fa-eye-slash");
            $toggle.attr("aria-label", isPwd ? "Hide password" : "Show password");
        });
        });

        $("#sidebarToggle").on("click", function () {
        $("#sidebar, #main-content").toggleClass("collapsed expanded");
        $(this).toggleClass("fa-chevron-left fa-chevron-right");
        });
        $("#userProfile").on("click", function (e) {
        e.stopPropagation();
        $(this).toggleClass("open");
        });
        $(document).on("click", function () {
        $("#userProfile").removeClass("open");
        });
        $(".otp-container input").each(function (i, input) {
        $(input).on({
            input(e) {
            this.value = this.value.replace(/\D/g, "");
            if (this.value && i < $(".otp-container input").length - 1)
                $(".otp-container input")
                .eq(i + 1)
                .focus();
            },
            keydown(e) {
            if (e.key === "Backspace" && !this.value && i > 0)
                $(".otp-container input")
                .eq(i - 1)
                .focus();
            },
            focus() {
            this.select();
            },
        });
        });

        if ($(".datepicker").length) {
        const yearSel = $("#year-select"),
            monthSel = $("#month-select"),
            weekSel = $("#week-select"),
            rangeDisp = $("#range-display"),
            now = new Date(),
            currentY = now.getFullYear(),
            monthNames = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December",
            ];

        for (let y = currentY - 5; y <= currentY + 5; y++)
            yearSel.append(new Option(y, y));
        monthNames.forEach((m, i) => monthSel.append(new Option(m, i)));
        function updateWeeks() {
            weekSel.empty();
            const year = +yearSel.val(),
            month = +monthSel.val();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            for (let start = 1; start <= daysInMonth; start += 6) {
            const end = Math.min(start + 5, daysInMonth);
            const fmt = (d) =>
                `${String(d.getDate()).padStart(2, "0")} ${monthNames[
                d.getMonth()
                ].slice(0, 3)}`;
            weekSel.append(
                new Option(
                `${fmt(new Date(year, month, start))} – ${fmt(
                    new Date(year, month, end)
                )}`,
                `${start}-${end}`
                )
            );
            }
            updateRange();
        }
        function updateRange() {
            const [s, e] = weekSel.val().split("-").map(Number);
            const sD = new Date(yearSel.val(), monthSel.val(), s);
            const eD = new Date(yearSel.val(), monthSel.val(), e);
            const fullFmt = (d) =>
            `${monthNames[d.getMonth()].slice(0, 3)} ${String(
                d.getDate()
            ).padStart(2, "0")}, ${d.getFullYear()}`;
            rangeDisp.text(`${fullFmt(sD)} – ${fullFmt(eD)}`);
        }
        yearSel.add(monthSel).on("change", updateWeeks);
        weekSel.on("change", updateRange);
        $("#btn-cancel").on("click", (e) => {
            e.preventDefault();
            updateWeeks();
        });
        $("#btn-apply").on("click", (e) => {
            e.preventDefault();
            alert("You picked: " + rangeDisp.text());
        });
        yearSel.val(currentY);
        monthSel.val(now.getMonth());
        updateWeeks();
        }
        const escapeHTML = (str) =>
        str.replace(
            /[&<>"]/g,
            (c) => ({"&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;"}[c])
        );
        function initToggleText() {
        $(".toggle-text-content").each(function () {
            const $c = $(this);
            const full = $c.text().trim();

            // store original text immediately
            $c.data("full", full);

            // ensure block layout and constrain width to parent's inner width for accurate measurement
            const parentInnerWidth =
            $c.parent().innerWidth() || $c.width() || $c.css("width");
            if (typeof parentInnerWidth === "number") {
            $c.css({display: "block", width: parentInnerWidth + "px"});
            } else {
            $c.css({display: "block", width: "100%"});
            }

            // reset before measuring
            $c.removeClass("expanded").css({height: "", overflow: "hidden"});

            // line-height: try CSS value first, fallback to computed font-size * 1.2
            let lh = parseFloat($c.css("line-height"));
            if (!lh || isNaN(lh)) {
            const fs = parseFloat($c.css("font-size")) || 16;
            lh = fs * 1.2;
            }
            const maxH = Math.round(lh * 2); // two lines height in px (rounded)

            // binary search on number of characters that will fit in two lines
            let lo = 0,
            hi = full.length,
            best = 0;
            while (lo <= hi) {
            const mid = Math.floor((lo + hi) / 2);
            // test mid characters (don't divide by weird factor)
            $c.html(
                escapeHTML(full.slice(0, mid)) +
                '… <a href="#" class="read-more">Read more <i class="fa-solid fa-arrow-right" style="transform:rotate(-45deg)"></i></a>'
            );
            // force browser to layout then test height
            if ($c[0].offsetHeight <= maxH) {
                best = mid;
                lo = mid + 1;
            } else {
                hi = mid - 1;
            }
            }

            // ensure we leave a little room so the "… Read more" fits on the second line
            const finalSlice = Math.max(0, best - 8);
            $c.html(
            escapeHTML(full.slice(0, finalSlice)) +
                '… <a href="#" class="read-more">Read more <i class="fa-solid fa-arrow-right" style="transform:rotate(-45deg)"></i></a>'
            ).css({height: maxH + "px", overflow: "hidden"});
        });

        // click handler
        $(".toggle-text-wrapper")
            .off("click.readmore")
            .on("click.readmore", ".read-more", function (e) {
            e.preventDefault();
            const $c = $(this)
                .closest(".toggle-text-wrapper")
                .find(".toggle-text-content");
            const full = $c.data("full") || "";
            const expanded = $c.toggleClass("expanded").hasClass("expanded");

            if (expanded) {
                // show full text and keep a Show less link
                $c.html(
                escapeHTML(full) +
                    ' <a href="#" class="read-more expanded">Show less <i class="fa-solid fa-arrow-right"></i></a>'
                ).css({height: "auto", overflow: ""});
            } else {
                // reinitialize truncation for the collapsed state
                initToggleText();
            }
            });
        }

        function initTabs() {
        $(".tab-wrapper").each(function () {
            const $wrapper = $(this);
            const $tabs = $wrapper.find(".cmn-tab-head ul li").not(".tab-bg");
            const $bg = $wrapper.find(".tab-bg");
            const $tables = $wrapper.find(".ds-cmn-tble");
            const $contents = $wrapper.find(".cmn-tab-content,.tab-cmn-content");
            $tabs.each(function (i) {
                const slug = $(this).text().trim().replace(/[\\/]/g, "").replace(/\s+/g, "-").replace(/[^\w-]/g, "").replace(/-+/g, "-").toLowerCase();
                $(this).attr("data-filter", "." + slug);
                $tables.eq(i).addClass(slug);
                $contents.eq(i).addClass(slug);
            });
            function updateTabBg() {
            const $active = $tabs.filter(".active");
            $bg.css({
                left: $active.position().left,
                top: $active.position().top,
                width: $active.outerWidth(),
                height: $active.outerHeight(),
            });
            }
            $tabs.removeClass("active").first().addClass("active");
            $tables.hide().removeClass("active").first().show().addClass("active");
            $contents
            .hide()
            .removeClass("active")
            .first()
            .show()
            .addClass("active");
            updateTabBg();

            $tabs.on("click", function () {
            const $t = $(this);
            const filter = $t.attr("data-filter");
            $tabs.removeClass("active");
            $t.addClass("active");
            updateTabBg();
            $tables.filter(".active").removeClass("active").fadeOut(300);
            $contents.filter(".active").removeClass("active").fadeOut(300);
            $tables.filter(filter).addClass("active").fadeIn(300);
            $contents.filter(filter).addClass("active").fadeIn(300);
            setTimeout(initToggleText, 350);
            });
        });
        }

        initToggleText();
        initTabs();
        $('a[data-bs-toggle="tab"]').on("shown.bs.tab", initToggleText);

        function closeAllMenus() {
        document
            .querySelectorAll(".dropdown-menu")
            .forEach((m) => (m.style.display = "none"));
        }
        document.querySelectorAll(".dropdown").forEach((drop) => {
        const btn = drop.querySelector(".dropdown-toggle"),
            menu = drop.querySelector(".dropdown-menu");
        btn.addEventListener("click", (e) => {
            e.stopPropagation();
            const open = menu.style.display === "block";
            closeAllMenus();
            menu.style.display = open ? "none" : "block";
        });
        menu.addEventListener("click", (e) => e.stopPropagation());
        });
        document.addEventListener("click", closeAllMenus);
        document
        .querySelectorAll('.subject-dropdown input[type="checkbox"]')
        .forEach((cb) =>
            cb.addEventListener("change", () => {
            const labels = Array.from(
                document.querySelectorAll(".subject-dropdown input:checked")
            ).map((i) => i.parentNode.textContent.trim());
            document.querySelector(".subject-dropdown .label").textContent =
                labels.length ? labels.join(", ") : "Select Subject";
            })
        );

        const dateDrop = document.querySelector(".date-dropdown");
        if (dateDrop) {
        const dateLabel = dateDrop.querySelector(".dropdown-toggle .label");
        const yearSel = dateDrop.querySelector(".year-select");
        const monSel = dateDrop.querySelector(".month-select");

        dateDrop.querySelector(".btn-cancel").addEventListener("click", (e) => {
            e.stopPropagation();
            closeAllMenus();
        });

        dateDrop.querySelector(".btn-apply").addEventListener("click", (e) => {
            e.stopPropagation();
            const monthNames = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December",
            ];
            const selectedMonth = monthNames[monSel.selectedIndex];
            const selectedYear = yearSel.value;
            dateLabel.textContent = `${selectedMonth}, ${selectedYear}`;
            closeAllMenus();
        });
        }

        const input = document.querySelector(".dest");
        const list = document.querySelector(".dest-list");
        const wrapper = document.querySelector(".dist-list-wrp");
        if (input || list || wrapper) {
        const data = [
            "Lorem ipsum dolor sit amet",
            "Lorem ipsum dolor sit amet 2",
            "Lorem ipsum dolor sit amet 3",
            "Lorem ipsum dolor sit amet 4",
            "Lorem ipsum dolor sit amet 5",
        ];
        function render(items) {
            list.innerHTML = "";
            if (items.length === 0) {
            list.hidden = true;
            wrapper.classList.remove("has-items");
            return;
            }
            items.forEach((text) => {
            const item = document.createElement("div");
            item.className = "autocomplete-item";
            item.textContent = text;
            item.addEventListener("click", () => {
                input.value = text;
                list.hidden = true;
                wrapper.classList.remove("has-items");
            });
            list.appendChild(item);
            });
            list.hidden = false;
            wrapper.classList.add("has-items");
        }

        input.addEventListener("input", () => {
            const val = input.value.trim().toLowerCase();
            render(
            val ? data.filter((item) => item.toLowerCase().includes(val)) : data
            );
        });

        document.addEventListener("click", (e) => {
            if (!e.target.closest(".autocomplete-list")) {
            list.hidden = true;
            wrapper.classList.remove("has-items");
            }
        });
        }

        const btns = document.querySelectorAll(".ibtn");
        btns.forEach((btn) => {
        if (btn) {
            const icon = btn.querySelector(".ibtn-icon");
            const notice = btn.querySelector(".ibtn-info");
            const closeBtn = btn.querySelector(".ibtn-close");
            icon.addEventListener("click", (e) => {
            e.preventDefault();
            notice.classList.add("show");
            });
            closeBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            notice.classList.remove("show");
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

        const hasInfoLinks = document.querySelectorAll(".has-info-card>a");
        const body = document.body;

        hasInfoLinks.forEach((link) => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            body.classList.add("no-scroll");
            const card = link
            .closest(".has-info-card")
            .querySelector(".notice-info-wrp");
            card.classList.toggle("active");
        });
        const closeBtn = link
            .closest(".has-info-card")
            .querySelector(".notice-info-wrp .notice-btn-close");
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

    const dd = document.getElementById("studentDropdown");
    if (dd) {
        const toggle = dd.querySelector(".choosestudentdrop-toggle");
        const menu = dd.querySelector(".choosestudentdrop-menu");
        const items = menu.querySelectorAll("li");
        toggle.addEventListener("click", () => {
        dd.classList.toggle("open");
        });
        items.forEach((item) => {
        item.addEventListener("click", () => {
            items.forEach((i) => i.classList.remove("selected"));
            item.classList.add("selected");
            dd.querySelector(".label").textContent = item.textContent;
            dd.classList.remove("open");
        });
        });
        document.addEventListener("click", (e) => {
        if (!dd.contains(e.target)) {
            dd.classList.remove("open");
        }
        });
    }

    (function () {
        const skip = (href) =>
        /^(?:https?:|\/\/|mailto:|tel:|javascript:|#)/i.test(href) ||
        href.startsWith("/");
        const pageFolder = window.location.pathname.replace(/\/[^/]*$/, "/");

        document.querySelectorAll("a[href]").forEach((a) => {
        const href = (a.getAttribute("href") || "").trim();
        if (!href || skip(href)) return;

        if (/\.(html?)($|[?#])/i.test(href)) {
            try {
            const resolved = new URL(href, location.origin + pageFolder);
            a.setAttribute(
                "href",
                resolved.pathname + (resolved.search || "") + (resolved.hash || "")
            );
            } catch (e) {
            a.setAttribute("href", pageFolder + href.replace(/^\.\//, ""));
            }
        }
        });
    })();

    const triggers = document.querySelectorAll(".dropdown-trigger");
    triggers.forEach((trigger) => {
        const optionsContainer =
        trigger.nextElementSibling &&
        trigger.nextElementSibling.classList.contains("dropdown-options") ? trigger.nextElementSibling : null;
        if (!optionsContainer) return;
        const options = Array.from(
        optionsContainer.querySelectorAll(".dropdown-option"));
        const label = trigger.querySelector(".dropdown-label");
        trigger.addEventListener("click", function (e) {
        e.stopPropagation();
        closeAllDropdowns(optionsContainer);
        const opened = optionsContainer.classList.toggle("show");
        trigger.setAttribute("aria-expanded", String(opened));
        });
        trigger.addEventListener("keydown", function (e) {
            if (e.key === "Enter" || e.key === " ") {
                e.preventDefault();
                trigger.click();
            }
        });
        options.forEach((option) => {
        option.addEventListener("click", function (e) {
            e.stopPropagation();
            const selectedValue = this.textContent.trim();
            if (label) label.textContent = selectedValue;
            trigger.dataset.selected = selectedValue;
            options.forEach((o) => o.classList.remove("selected"));
            this.classList.add("selected");
            optionsContainer.classList.remove("show");
            trigger.setAttribute("aria-expanded", "false");
        });
        });
    });

    function closeAllDropdowns(current = null) {
        document.querySelectorAll(".dropdown-options.show").forEach((menu) => {
        if (menu !== current) {
            menu.classList.remove("show");
            const trig =
            menu.previousElementSibling &&
            menu.previousElementSibling.classList.contains("dropdown-trigger")
                ? menu.previousElementSibling
                : null;
            if (trig) trig.setAttribute("aria-expanded", "false");
        }
        });
    }
    window.addEventListener("click", function () {
        closeAllDropdowns();
    });

    const fileInput = document.getElementById("fileUpload");
    const fileText = document.querySelector(".file-text");
    if (fileInput) {
        fileInput.addEventListener("change", function () {
            const files = Array.from(this.files || []);
            if (files.length === 0) {
                fileText.textContent = "No file chosen";
            } else if (files.length === 1) {
                fileText.textContent = files[0].name;
            } else {
                fileText.textContent = files.length + " files selected";
            }
        });
    }

  // SS08092025

    if ($(".sidebar .sidebar-body ul li.menu-item-has-children > a").length) {
        $(".sidebar .sidebar-body ul li.menu-item-has-children > a").each(
        function () {
            if (!$(this).next(".clickD").length) {
            $("<span class='clickD'></span>").insertAfter(this);
            }
        }
        );
    }
    $(".sidebar").off("click", ".clickD").on("click", ".clickD", function (e) {
        e.preventDefault();
        e.stopPropagation();
        let $this = $(this);
        let $submenu = $this.next(".sub-menu");
        if ($submenu.hasClass("show")) {
            $submenu.removeClass("show");
            $this.removeClass("toggled");
        } else {
            $this.closest(".sidebar-body").find(".sub-menu").removeClass("show");
            $this.closest(".sidebar-body").find(".clickD.toggled").removeClass("toggled");
            $submenu.addClass("show");
            $this.addClass("toggled");
        }
    });
    function _closeSidebarMenus() {
        $(".sidebar .sidebar-body").find(".sub-menu").removeClass("show");
        $(".sidebar .sidebar-body").find(".clickD.toggled").removeClass("toggled");
    }
    function _bindOutsideClickForSmallScreens() {
        let namespace = "click.sidebarClose";
        $(document).off(namespace);
        $(".sidebar").off("click.stopProp");
        if ($(window).width() < 1025) {
        $(document).on(namespace, function () {
            _closeSidebarMenus();
        });
        $(".sidebar").on("click.stopProp", function (e) {
            e.stopPropagation();
        });
        } else {
            $(document).off(namespace);
            $(".sidebar").off("click.stopProp");
        }
    }
    _bindOutsideClickForSmallScreens();
    let _resizeTimer = null;
    $(window).on("resize", function () {
        clearTimeout(_resizeTimer);
        _resizeTimer = setTimeout(function () {
        _bindOutsideClickForSmallScreens();
        }, 120);
    });


    // SS141025 Begin

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.cmn-form-row').forEach((row, idx) => {
          const btn = row.querySelector('.action-btn[data-action="collapse"]');
          const target = row.querySelector('.cmn-form-inr-row, .cmn-box-style');
          if (!btn || !target) return;
          if (!target.id) target.id = `cmn-collapse-${Date.now().toString(36)}-${idx}`;
          const isCollapsed = target.classList.contains('is-collapsed');
          btn.setAttribute('aria-expanded', String(!isCollapsed));
          btn.setAttribute('aria-pressed', String(!isCollapsed));
          btn.setAttribute('aria-controls', target.id);
          target.setAttribute('aria-hidden', String(isCollapsed));
          if (!btn.hasAttribute('type')) btn.type = 'button';
        });
      });
      
      document.addEventListener('click', (e) => {
        const btn = e.target.closest('.action-toolbar .action-btn[data-action="collapse"]');
        if (!btn) return;
        e.preventDefault();
        const row = btn.closest('.cmn-form-row');
        if (!row) return;
        const target = row.querySelector('.cmn-form-inr-row, .cmn-box-style');
        if (!target) return;
        const currentlyExpanded = btn.getAttribute('aria-expanded') === 'true';
        const willExpand = !currentlyExpanded;
        btn.setAttribute('aria-expanded', String(willExpand));
        btn.setAttribute('aria-pressed', String(willExpand));
        btn.setAttribute('aria-controls', target.id);
        target.setAttribute('aria-hidden', String(!willExpand));
        target.classList.toggle('is-collapsed', !willExpand);
        const icon = btn.querySelector('i, img');
        if (icon) {
          icon.style.transition = 'transform 200ms ease';
          icon.style.transform = willExpand ? 'rotate(180deg)' : '';
        }
    });  


    // End Of SS141025

    // SS271025 Begin

    const container = document.querySelector(".ds-breadcrumb");
    if (container) {
        const breadWrp = document.createElement("div");
        breadWrp.className = "bread-left-wrp";
        const h1 = container.querySelector("h1");
        const ul = container.querySelector("ul");
        const insertBeforeEl = container.querySelector(".back-btn , .btn-wrp") || container.firstElementChild;
        container.insertBefore(breadWrp, insertBeforeEl);
        if (h1) breadWrp.appendChild(h1);
        if (ul) breadWrp.appendChild(ul);
    }

    if($(".application-accr,.sidebar-form").length){
        $(".accr-head,.sidebar-cat-head").click(function () {
            $(this).next().stop(true, true).slideToggle();
            $(this).parent(".accr-item,.sidebar-category").siblings().find(".accr-content,.sidebar-cat-body").slideUp();
            $(this).parents(".accr-item,.sidebar-category").siblings().find(".accr-content,.sidebar-cat-body").slideUp();
            // $(".application-accr .accr-item,.sidebar-category").eq(0).find(".accr-content,.sidebar-cat-body").slideUp();
        });
    
        $(".application-accr .accr-item,.sidebar-category").find(".accr-content,.sidebar-cat-body").slideUp();
        $(".application-accr .accr-item,.sidebar-category").eq(0).find(".accr-content,.sidebar-cat-body").slideDown();
    };

    // End Of SS271025
    (function(){
        const FLATPICKR_CSS = 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css';
        const FLATPICKR_JS  = 'https://cdn.jsdelivr.net/npm/flatpickr';
        let flatLoaded = false;
        let fpInstance = null;
      
        const $input = document.getElementById('due');
        const $panel = document.getElementById('panel');
        const $apply = document.getElementById('btn-apply');
        const $cancel = document.getElementById('btn-cancel');
      
        function loadScript(url){ return new Promise((res, rej) => {
          const s = document.createElement('script'); s.src = url; s.async = true;
          s.onload = () => res(); s.onerror = () => rej(new Error('Script load error: '+url));
          document.head.appendChild(s);
        });}
      
        function loadCss(url){ return new Promise((res, rej) => {
          const l = document.createElement('link'); l.rel='stylesheet'; l.href=url;
          l.onload = () => res(); l.onerror = () => rej(new Error('CSS load error: '+url));
          document.head.appendChild(l);
        });}
      
        async function initFlatpickr() {
          if (flatLoaded) return;
          try {
            await loadCss(FLATPICKR_CSS);
            await loadScript(FLATPICKR_JS);
            flatLoaded = true;
      
            // create a container inside panel to host flatpickr inline calendar
            const calWrap = document.createElement('div');
            calWrap.id = 'fp-calendar';
            // optionally: style the calendar wrapper to match your UI
            document.getElementById('calendar').appendChild(calWrap);
      
            // initialize flatpickr inline
            fpInstance = flatpickr('#fp-calendar', {
              inline: true,
              allowInput: false,
              monthSelectorType: 'static',
              showMonths: 1,
              // disable selecting other month days: use `onDayCreate` to style them
              onReady: function(selectedDates, dateStr, instance) {
                // initial panel title
                updateTitle(instance.currentMonth, instance.currentYear);
              },
              onMonthChange: function(selectedDates, dateStr, instance) {
                updateTitle(instance.currentMonth, instance.currentYear);
              },
              onChange: function(selectedDates, dateStr, instance) {
                // store temporary selection
                fpInstance.tempSelected = selectedDates.length ? selectedDates[0] : null;
              },
              onDayCreate: function(dObj, dStr, fp, dayElem){
                // grey out days not in the current month
                const dayMonth = dayElem.dateObj.getMonth();
                if (dayMonth !== fp.currentMonth) {
                  dayElem.classList.add('other-month-day');
                  dayElem.style.opacity = '0.6';
                  dayElem.style.pointerEvents = 'none'; // prevent selecting other-month days
                }
              }
            });
      
            // helper to set header title
            function updateTitle(month, year){
              const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
              const title = months[month] + ' ' + year;
              const el = document.getElementById('panel-title');
              if(el) el.textContent = title;
            }
      
          } catch (err) {
            console.error('Failed to load datepicker assets:', err);
          }
        }
      
        // open the panel and lazy-load if needed
        $input.addEventListener('click', async function(ev){
          ev.stopPropagation();
          $panel.style.display = 'block';
          if (!flatLoaded) await initFlatpickr();
        }, false);
      
        // Apply / Cancel behavior
        $apply.addEventListener('click', function(e){
          e.preventDefault();
          if (fpInstance && fpInstance.tempSelected) {
            const d = fpInstance.formatDate(fpInstance.tempSelected, 'd M Y'); // example: 30 Jan 2023
            $input.value = d;
            // set selected date in calendar
            fpInstance.setDate(fpInstance.tempSelected, false);
          }
          $panel.style.display = 'none';
        }, false);
      
        $cancel.addEventListener('click', function(e){
          e.preventDefault();
          // revert temporary selection (flatpickr keeps selectedDates separately)
          if (fpInstance) {
            fpInstance.tempSelected = null;
            // you may want to reset UI selection to the previously applied date:
            // fpInstance.setDate(existingDate, false);
          }
          $panel.style.display = 'none';
        }, false);
      
        // close on outside click
        document.addEventListener('mousedown', function(e){
          if (!e.target.closest('.datepicker-panel') && e.target !== $input) {
            $panel.style.display = 'none';
          }
        });
      
      })();
    

    // Document End

});


