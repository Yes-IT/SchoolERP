(function(){
    const el = document.querySelector('.date-range-picker');
    if(!el) return;
  
    const input = el.querySelector('.dr-input');
    const icon = el.querySelector('.dr-icon-btn');
    const popup = el.querySelector('.dr-popup');
    const leftMonthName = el.querySelector('.dr-month-left');
    const rightMonthName = el.querySelector('.dr-month-right');
    const leftCal = el.querySelector('.dr-cal-left');
    const rightCal = el.querySelector('.dr-cal-right');
    const prevBtn = el.querySelector('.dr-prev');
    const nextBtn = el.querySelector('.dr-next');
    const selectedLabel = el.querySelector('.dr-selected');
    const cancelBtn = el.querySelector('.dr-cancel');
    const applyBtn = el.querySelector('.dr-apply');
  
    // state
    const today = new Date();
    let viewYear = today.getFullYear();
    let viewMonth = today.getMonth(); // left month index
    let startDate = null;
    let endDate = null;
    let appliedStart = null;
    let appliedEnd = null;
  
    function formatDMY(d){ // dd/mm/yyyy
      const dd = String(d.getDate()).padStart(2,'0');
      const mm = String(d.getMonth()+1).padStart(2,'0');
      const yy = d.getFullYear();
      return `${dd}/${mm}/${yy}`;
    }
  
    function clearNode(n){ while(n.firstChild) n.removeChild(n.firstChild); }
  
    function buildCalendar(container, year, month, index){
      clearNode(container);
      // month label
      const monthNames = ['January','February','March','April','May','June','July','August','September','October','November','December'];
      const title = document.createElement('div');
      title.className = 'dr-title';
      title.textContent = `${monthNames[month]} ${year}`;
    //   container.appendChild(title);/
  
      // weekdays
      const wk = document.createElement('div'); wk.className = 'dr-weekdays';
      ['Su','Mo','Tu','We','Th','Fr','Sa'].forEach(n => {
        const d = document.createElement('div'); d.textContent = n; wk.appendChild(d);
      });
      container.appendChild(wk);
  
      // days wrapper
      const daysWrap = document.createElement('div'); daysWrap.className = 'dr-days';
  
      // first day of this month (0..6)
      const first = new Date(year, month, 1);
      const startWeekDay = first.getDay();
      // number of days in month
      const daysInMonth = new Date(year, month+1, 0).getDate();
  
      // fill leading blanks
      for(let i=0;i<startWeekDay;i++){
        const blank = document.createElement('div');
        blank.className = 'dr-day disabled';
        daysWrap.appendChild(blank);
      }
  
      // days
      for(let d=1; d<=daysInMonth; d++){
        const date = new Date(year, month, d);
        const dEl = document.createElement('div');
        dEl.className = 'dr-day';
        dEl.dataset.time = date.getTime();
        dEl.textContent = d;
  
        // attach click
        dEl.addEventListener('click', function(){
          if(dEl.classList.contains('disabled')) return;
          onDayClick(date);
        });
  
        daysWrap.appendChild(dEl);
      }
  
      container.appendChild(daysWrap);
    }
  
    function render() {
      // left = viewYear, viewMonth
      buildCalendar(leftCal, viewYear, viewMonth, 0);
  
      // right month
      const rightDate = new Date(viewYear, viewMonth+1, 1);
      buildCalendar(rightCal, rightDate.getFullYear(), rightDate.getMonth(), 1);
  
      leftMonthName.textContent = formatMonth(viewYear, viewMonth);
      rightMonthName.textContent = formatMonth(rightDate.getFullYear(), rightDate.getMonth());
  
      // highlight range & selected days
      highlightRange();
      updateFooter();
    }
  
    function formatMonth(y,m){
      const mn = ['January','February','March','April','May','June','July','August','September','October','November','December'];
      return `${mn[m]} ${y}`;
    }
  
    function onDayClick(date){
      // clicking sets start/end
      if(!startDate || (startDate && endDate)){
        startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        endDate = null;
      } else {
        const candidate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        if(candidate.getTime() < startDate.getTime()){
          // if clicked before start, swap: make new start and keep old start as end
          endDate = startDate;
          startDate = candidate;
        } else {
          endDate = candidate;
        }
      }
      highlightRange();
      updateFooter();
    }
  
    function highlightRange(){
      // remove existing classes
      el.querySelectorAll('.dr-day').forEach(node => {
        node.classList.remove('in-range','start','end');
        // disabled remains if it has dataset.time undefined
      });
  
      const nodes = el.querySelectorAll('.dr-day[data-time]');
      nodes.forEach(node => {
        const t = parseInt(node.dataset.time,10);
        const d = new Date(t);
        if(startDate && !endDate){
          if(sameDay(d, startDate)) node.classList.add('start');
        } else if(startDate && endDate){
          if(sameDay(d,startDate)) node.classList.add('start');
          else if(sameDay(d,endDate)) node.classList.add('end');
          else if(t > startDate.getTime() && t < endDate.getTime()) node.classList.add('in-range');
        }
      });
    }
  
    function updateFooter(){
      if(startDate && endDate){
        selectedLabel.textContent = `${formatDMY(startDate)} - ${formatDMY(endDate)}`;
      } else if(startDate && !endDate){
        selectedLabel.textContent = `${formatDMY(startDate)} - —`;
      } else {
        selectedLabel.textContent = '—';
      }
    }
  
    function sameDay(a,b){
      return a.getFullYear()===b.getFullYear() && a.getMonth()===b.getMonth() && a.getDate()===b.getDate();
    }
  
    // nav handlers
    prevBtn.addEventListener('click', function(){
      viewMonth -= 1;
      if(viewMonth < 0){ viewMonth = 11; viewYear -= 1; }
      render();
    });
    nextBtn.addEventListener('click', function(){
      viewMonth += 1;
      if(viewMonth > 11){ viewMonth = 0; viewYear += 1; }
      render();
    });
  
    // open/close
    function openPopup(){
      popup.setAttribute('aria-hidden','false');
      popup.style.display = 'block';
      render();
    }
    function closePopup(){
      popup.setAttribute('aria-hidden','true');
      popup.style.display = 'none';
    }
  
    icon.addEventListener('click', function(){ openPopup(); });
    input.addEventListener('click', function(){ openPopup(); });
  
    // cancel: revert to applied values
    cancelBtn.addEventListener('click', function(){
      startDate = appliedStart ? new Date(appliedStart.getTime()) : null;
      endDate = appliedEnd ? new Date(appliedEnd.getTime()) : null;
      render();
      closePopup();
    });
    applyBtn.addEventListener('click', function(){
      appliedStart = startDate ? new Date(startDate.getTime()) : null;
      appliedEnd = endDate ? new Date(endDate.getTime()) : null;
      if(appliedStart && appliedEnd){
        input.value = `${formatDMY(appliedStart)} - ${formatDMY(appliedEnd)}`;
      } else if(appliedStart && !appliedEnd){
        input.value = `${formatDMY(appliedStart)} - ${formatDMY(appliedStart)}`;
      } else {
        input.value = '';
      }
      closePopup();
    });
    document.addEventListener('click', function(ev){
      if(!el.contains(ev.target) && popup.getAttribute('aria-hidden') === 'false'){
        startDate = appliedStart ? new Date(appliedStart.getTime()) : null;
        endDate = appliedEnd ? new Date(appliedEnd.getTime()) : null;
        closePopup();
      }
    });
    function init(){
      viewYear = today.getFullYear();
      viewMonth = today.getMonth();
      appliedStart = null; appliedEnd = null;
      render();
    }
  
    init();
  
  })();