
function status_show(e,id) { 
  const check = e.checked === true ? 1 : 0;
  const previousChecked = !e.checked;
  const csrfToken = $('meta[name="csrf-token"]').attr('content') || '';

  const applyStatusClass = (checkedState) => {
    if (checkedState === true) {
      $('#statusArea' + id).addClass('status-room-active');
      $('#statusArea' + id).removeClass('status-room');
    } else {
      $('#statusArea' + id).removeClass('status-room-active');
      $('#statusArea' + id).addClass('status-room');
    }
  };

  e.disabled = true;

  $.ajax({
    type: "POST",
    url: "../server/admin/room/status_toggle.php",
    data: {
        status: check, // สถานะใหม่ที่จะสลับ
        id: id, // ID ของห้องที่จะสลับสถานะ
        csrf_token: csrfToken
    },
    dataType: "json",
    success: function (response) {
      if(response && response.success) {
        applyStatusClass(e.checked);
        return;
      }

      e.checked = previousChecked;
      applyStatusClass(previousChecked);
      alert((response && response.message) ? response.message : 'เกิดข้อผิดพลาดในการสลับสถานะ');
    },
    error: function () {
      e.checked = previousChecked;
      applyStatusClass(previousChecked);
      alert('ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง');
    },
    complete: function () {
      e.disabled = false;
    }
});

  
};

$(document).ready(function () {



  $('#file_Image').change(function (e) { 
    e.preventDefault();
    file_img = e.target.files[0];
    console.log(e.target.files);
    
      const reader_image = new FileReader();
      reader_image.onload = () => {
        $('#preview_image').attr('src', reader_image.result);
        $('#preview_image').attr('alt', reader_image.result);
      };
      reader_image.readAsDataURL(file_img);
    
  });
  // alert('connected!')

      // $(function(){
      //     // กำหนด element ที่จะแสดงปฏิทิน
      //   var calendarEl = $("#calendar")[0];
 
      //     // กำหนดการตั้งค่า
      //   var calendar = new FullCalendar.Calendar(calendarEl, {
      //       plugins: [ 'interaction','dayGrid', 'timeGrid', 'list' ], // plugin ที่เราจะใช้งาน
      //       defaultView: 'dayGridMonth', // ค้าเริ่มร้นเมื่อโหลดแสดงปฏิทิน
      //       header: {
      //           left: 'prev,next today',
      //           center: 'title',
      //           right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      //       },  
      //       eventLimit: true, // allow "more" link when too many events
      //       locale: 'th',    // กำหนดให้แสดงภาษาไทย
      //       firstDay: 0, // กำหนดวันแรกในปฏิทินเป็นวันอาทิตย์ 0 เป็นวันจันทร์ 1
      //       showNonCurrentDates: false, // แสดงที่ของเดือนอื่นหรือไม่
      //       eventTimeFormat: { // รูปแบบการแสดงของเวลา เช่น '14:30' 
      //           hour: '2-digit',
      //           minute: '2-digit',
      //           meridiem: false
      //       },
      //       events:[
      //         {
      //           title:'test MCR Booking',
      //           start:'2024-08-18T08:30',
      //           end:'2024-08-20T16:30'
      //         }
      //       ]
      //   });
          
      //    // แสดงปฏิทิน 
      //   calendar.render();  
           
      // });
});
