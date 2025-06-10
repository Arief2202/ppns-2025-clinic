let arrow = document.querySelectorAll(".arrow");
for (var i = 0; i < arrow.length; i++) {
  arrow[i].addEventListener("click", (e)=>{
 let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
 arrowParent.classList.toggle("showMenu");
  });
}

const body = document.querySelector('body'),
      toggle = body.querySelector(".toggle"),
      searchBtn = body.querySelector(".search-box"),
      modeSwitch = body.querySelector(".toggle-switch"),
      modeText = body.querySelector(".mode-text");
var meta = document.getElementsByTagName("meta");
let _token = meta[3].content;
let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".toggle");

sidebarBtn.addEventListener("click", ()=>{
  sidebar.classList.toggle("close");
  var sideBarStateVal = 0;
    if(sidebar.classList.contains("close")){
        sideBarStateVal = 0;
    }else{
        sideBarStateVal = 1;
    }
    $(function(){
        document.getElementById("darklightButton").style.display = sideBarStateVal == 0 ? "none" : "flex";
        console.log(sideBarStateVal);
        $.ajax({
            url: "/changeSideBarState",
            type:"POST",
            data:{
                sideBarState: sideBarStateVal,
                _token: _token
            }
        });
    });
});


modeSwitch.addEventListener("click" , () =>{
  body.classList.toggle("dark");
  var darkModeVal = 0;
  if(body.classList.contains("dark")){
      darkModeVal = 1;
  }else{
      darkModeVal = 0;
  }

  $(function(){
      $.ajax({
          url: "/changeDarkMode",
          type:"POST",
          data:{
              darkMode: darkModeVal,
              _token: _token
          }
      });
  });


});


window.onkeyup = function(e){
  if(e.keyCode == 66 && e.ctrlKey || e.keyCode == 27){
    sidebar.classList.toggle("close");
    var sideBarStateVal = 0;
      if(sidebar.classList.contains("close")){
          sideBarStateVal = 0;
      }else{
          sideBarStateVal = 1;
      }
      $(function(){
        document.getElementById("darklightButton").style.display = sideBarStateVal == 0 ? "none" : "flex";
          $.ajax({
              url: "/changeSideBarState",
              type:"POST",
              data:{
                  sideBarState: sideBarStateVal,
                  _token: _token
              }
          });
      });
  }
  // else{
  //   console.log(e.keyCode);
  // }
}
