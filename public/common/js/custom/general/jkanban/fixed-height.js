(()=>{"use strict";var t,s,e,l=(e=function(t){s.querySelectorAll(".kanban-drag").forEach((function(t){var s=t.querySelector(".gu-transit");if(s){var e=t.getBoundingClientRect(),l=s.offsetHeight,a=document.querySelector(".gu-mirror").getBoundingClientRect(),n=a.top-e.top,o=e.bottom-a.bottom;n<=l?t.scroll({top:t.scrollTop-3}):o<=l?t.scroll({top:t.scrollTop+3}):t.scroll({top:t.scrollTop})}}))},{init:function(){var l;t="#kt_docs_jkanban_fixed_height",s=document.querySelector(t),l=s.getAttribute("data-kt-jkanban-height"),new jKanban({element:t,gutter:"0",widthBoard:"250px",boards:[{id:"_fixed_height",title:"Fixed Height",class:"primary",item:[{title:'<span class="fw-bold">Item 1</span>'},{title:'<span class="fw-bold">Item 2</span>'},{title:'<span class="fw-bold">Item 3</span>'},{title:'<span class="fw-bold">Item 4</span>'},{title:'<span class="fw-bold">Item 5</span>'},{title:'<span class="fw-bold">Item 6</span>'},{title:'<span class="fw-bold">Item 7</span>'},{title:'<span class="fw-bold">Item 8</span>'},{title:'<span class="fw-bold">Item 9</span>'},{title:'<span class="fw-bold">Item 10</span>'},{title:'<span class="fw-bold">Item 11</span>'},{title:'<span class="fw-bold">Item 12</span>'},{title:'<span class="fw-bold">Item 13</span>'},{title:'<span class="fw-bold">Item 14</span>'},{title:'<span class="fw-bold">Item 15</span>'}]},{id:"_fixed_height2",title:"Fixed Height 2",class:"success",item:[{title:'<span class="fw-bold">Item 1</span>'},{title:'<span class="fw-bold">Item 2</span>'},{title:'<span class="fw-bold">Item 3</span>'},{title:'<span class="fw-bold">Item 4</span>'},{title:'<span class="fw-bold">Item 5</span>'},{title:'<span class="fw-bold">Item 6</span>'},{title:'<span class="fw-bold">Item 7</span>'},{title:'<span class="fw-bold">Item 8</span>'},{title:'<span class="fw-bold">Item 9</span>'},{title:'<span class="fw-bold">Item 10</span>'},{title:'<span class="fw-bold">Item 11</span>'},{title:'<span class="fw-bold">Item 12</span>'},{title:'<span class="fw-bold">Item 13</span>'},{title:'<span class="fw-bold">Item 14</span>'},{title:'<span class="fw-bold">Item 15</span>'}]}],dragEl:function(t,s){document.addEventListener("mousemove",e)},dragendEl:function(t){document.removeEventListener("mousemove",e)}}),s.querySelectorAll(".kanban-drag").forEach((function(t){t.style.maxHeight=l+"px"}))}});KTUtil.onDOMContentLoaded((function(){l.init()}))})();