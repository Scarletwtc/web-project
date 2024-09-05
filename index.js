window.onload = function () 
{
    document.querySelectorAll('.delete-note').forEach(button => {
button.addEventListener('click', function() {
    let noteId = this.dataset.noteId;
    deleteNote(noteId);
});
});



function deleteNote(noteId) {
let xhr = new XMLHttpRequest();
xhr.open('POST', 'delete_note.php', true);
xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
xhr.onload = function() {
    if (this.status === 200 && this.responseText === 'success') {
        let noteElement = document.querySelector(`button[data-note-id="${noteId}"]`).parentElement;
        noteElement.remove();
    } else {
        alert('Failed to delete note.');
    }
};
xhr.send(`note_id=${noteId}`);
}


let todo=document.getElementById("todo");
let todobtn=document.getElementById("todobtn");
let notesbtn=document.getElementById("notesbtn");
let notes=document.getElementById("notes");
let clock=document.getElementById('clock');
let pombtn=document.getElementById('pombtn');
let calendar= document.getElementById('chooser');
let calbtn= document.getElementById('calbtn');
let about =document.getElementById('about');

calbtn.addEventListener('click', ()=>{
    if(calendar.style.display === 'none'){
        calendar.style.display = 'block';
        todo.style.display="none";
        notes.style.display="none";
        clock.style.display="none";
        about.style.display='none';
        
    } else {
        todo.style.display="none";
        notes.style.display="none";
        clock.style.display="none";
        calendar.style.display = 'none';
        about.style.display='none';
    }
});

todobtn.addEventListener('click', function(){
    if( todo.style.display=== 'none'){todo.style.display="block";
    notes.style.display="none"; clock.style.display="none";calendar.style.display = 'none';about.style.display='none';}
    else
    {
        todo.style.display="none";
        notes.style.display="none";
        clock.style.display="none";
        calendar.style.display = 'none';
        about.style.display='none';
    }
});

notesbtn.addEventListener('click', function(){
    if( notes.style.display=== 'none'){notes.style.display="block";
    todo.style.display="none"; clock.style.display="none";calendar.style.display = 'none';about.style.display='none';}
    else{
    notes.style.display="none";
    todo.style.display="none";
    clock.style.display="none";
    calendar.style.display = 'none';
    about.style.display='none';
    }
});



pombtn.addEventListener('click', function(){
    if( clock.style.display=== 'none'){clock.style.display="flex";
    todo.style.display="none"; notes.style.display="none"; calendar.style.display = 'none'; about.style.display='none';}
    else{
    notes.style.display="none";
    todo.style.display="none";
    clock.style.display="none";
    calendar.style.display = 'none';
    about.style.display='none';
    }
});






let tasks = document.querySelectorAll('.todo-item');
let pendingBtn=document.getElementById('pending');
let completedBtn=document.getElementById('completed');
let all=document.getElementById('all');

 //abd is the goat
pendingBtn.addEventListener('click', function() {
        tasks.forEach(todo => {
            if (todo.querySelector('input[type="checkbox"]').checked) {
                todo.style.display = "none";
            } else {
                todo.style.display = "flex";
            }
        });
    });

    completedBtn.addEventListener('click', function() {
        tasks.forEach(todo => {
            if (todo.querySelector('input[type="checkbox"]').checked) {
                todo.style.display = "flex";
            } else {
                todo.style.display = "none";
            }
        });
    });

    all.addEventListener('click', function(){
        tasks.forEach(todo => {
            todo.style.display="flex";
        });
    });




//pomo
let countdown;
let timerDisplay = document.getElementById('timer');
let startBtn = document.getElementById('startBtn');
let resetBtn = document.getElementById('resetBtn');

let minutes = 25;
let seconds = 0;
isRunning = false;

function startTimer() {
if (!isRunning) {
countdown = setInterval(decreaseTime, 1000);
isRunning = true;
startBtn.innerHTML = '<i class="fa-solid fa-pause"></i>';
} else {
clearInterval(countdown);
isRunning = false;
startBtn.innerHTML = '<i class="fa-solid fa-play"></i>';
}
}

function decreaseTime() {
if (seconds === 0) {
if (minutes === 0) {
  clearInterval(countdown);
  timerDisplay.innerHTML = "Time's up! Good job <3";
  return;
} else {
  minutes--;
  seconds = 59;
}
} else {
seconds--;
}

timerDisplay.innerHTML = padTime(minutes) + ":" + padTime(seconds);
}
//<i class="fa-solid fa-play"></i> play button
//<i class="fa-solid fa-power-off"></i> play buttton

function padTime(time) {
return time < 10 ? "0" + time : time;
}

function resetTimer() {
clearInterval(countdown);
isRunning = false;
minutes = 25;
seconds = 0;
timerDisplay.innerHTML = padTime(minutes) + ":" + padTime(seconds);
startBtn.innerHTML = '<i class="fas fa-play"></i>';
}

startBtn.addEventListener('click', startTimer);
resetBtn.addEventListener('click', resetTimer);





/*music */








let setti = document.getElementById('setti');
let settings = document.getElementById('settings');
setti.addEventListener('click',()=>{
    if( settings.style.display === 'none'){
    settings.style.display= 'block';


    }else{
        settings.style.display= 'none';
    }
});



let quotes=document.getElementById('quotes');
let next =document.getElementById('next');

let arr= [
    "One day, all your hard work will pay off.",
    'The earlier you start working on something, the earlier you will see results.',
    'Life is short. Live it. Fear is natural. Face it. Memory is powerful. Use it.',
    'Do what is right, not what is easy.',
    'We generate fears while we do nothing. We overcome these fears by taking action.',
    'If we wait until we are ready, we will be waiting for the rest of our lives.',
    'It is never too late to be what you might have been.',
];

let i=0
function changeq(){
    i=(i+1) % arr.length;
    quotes.innerHTML=arr[i];
}

next.addEventListener('mouseover', changeq);


let bac=document.getElementById('bac');
let circlebox=document.getElementsByClassName('circle_box');

let colorarr=[
    'red', 'blue', 'green', 'pink', 'yellow', 'black', 'purple', 'navyblue', 'darkgreen', 'gray',
    'crimson', 'blueviolet', 'brown', 'chartreuse',
];

let j=0;
function changetextc(){
    j=(j+1)%colorarr.length;
    circlebox[0].style.backgroundColor=colorarr[j];
    startBtn.style.backgroundColor=colorarr[j];
    resetBtn.style.backgroundColor=colorarr[j];
}

bac.addEventListener('click', changetextc);








let heads=0;
let tails=0;
let coin=document.getElementsByClassName("thecoin");
let flipcoin=document.getElementById('flipcoin');
let resetflip = document.getElementById('resetflip');


flipcoin.addEventListener('click', () =>{
    let x=Math.floor(Math.random()*2);
    coin[0].style.animation = "none";
    if(x){
        setTimeout(function(){
            coin[0].style.animation = "spin-heads 3s forwards";
        }, 100);
        heads++;
    }
    else{
        setTimeout(function(){
            coin[0].style.animation = "spin-tails 3s forwards";
        }, 100);
        tails++;
    }

    setTimeout(updateStats, 3000);
    disableButton();
});
function updateStats(){
    document.getElementById("heads").innerHTML = `Heads: ${heads}`;
    document.getElementById("tails").innerHTML = `Tails: ${tails}`;
}
function disableButton(){
    flipcoin.disabled = true;
    setTimeout(function(){
        flipcoin.disabled = false;
    },3000);
}
resetflip.addEventListener("click",() => {
    coin[0].style.animation = "none";
    heads = 0;
    tails = 0;
    updateStats();
});

let coinflip=document.getElementById('coinflip');
let clickcoin=document.getElementById('clickcoin');

clickcoin.addEventListener('click', () =>{
        if( coinflip.style.display === 'none'){
            coinflip.style.display='flex';
        }
        else{
            coinflip.style.display='none';
        }
});

let yesnobtn=document.getElementById('yesnobtn');
let askme =document.getElementById('askme');
let theanswer = document.getElementById('theanswer');

yesnobtn.addEventListener('click', ()=>{
    if( askme.style.display === 'none'){
        askme.style.display='flex';
    }
    else{
        askme.style.display='none';
    }
});

function chooseyesno() {
    let y = Math.floor(Math.random() * 120);
    if (y % 2 === 0) {
        theanswer.innerHTML = "yes";
    } else {
        theanswer.innerHTML = "no";
    }

    // Clear the input field
    question.value = "";
}

question = document.getElementById('question');
question.addEventListener('keypress', (event) => {
    if (event.key === 'Enter') {
        chooseyesno();
    }
});





}
