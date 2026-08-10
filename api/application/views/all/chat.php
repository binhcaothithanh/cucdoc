<div id="chat"></div>
<input id="q" placeholder="Nhập câu hỏi..." />
<button onclick="ask()">Hỏi</button>

<script>
function ask(){
 fetch('/chat/ask',{
  method:'POST',
  headers:{'Content-Type':'application/x-www-form-urlencoded'},
  body:'question='+q.value+'&device_id=demo-device-001'
 }).then(r=>r.json()).then(d=>{
  chat.innerHTML += '<p><b>Bạn:</b>'+q.value+'</p>';
  chat.innerHTML += '<p><b>App:</b>'+(d.answer||d.error)+'</p>';
  q.value='';
 });
}
</script>
