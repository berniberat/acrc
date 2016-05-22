

var isOn = false;
var aniOn = 0.00;
var p01 = 0.0;
var globalT = 0.0;

function rotatePiece ( id, deg ){
  $("#logo"+id).css('transform','rotate('+deg+'deg)' );
}

  
var tmp=0;  var tmpMax=0;

function animate( force ) {

  
  
  if (isOn) aniOn = 0.02 + 0.98*aniOn;
  else aniOn = 0.96*aniOn;
  
  if (force===undefined && aniOn < 0.01) return;
  
  
  var pulses_per_sec = 0.8;
  var t = (new Date()).getTime() * 0.001 * Math.PI * pulses_per_sec; 
  
  var s = ( Math.sin(t) );
  var s2 = Math.abs( Math.sin(2*t) *Math.sin(2*t))*0.65+0.35;
  
  /* angles:
       p01: continous gears
       p02: heart beat
       p03: back and forth
  */
  var p02 = aniOn*0.3*(-10+(s*s*s*s*s*s*s2*s2)*100) ;
  
  var p03 = aniOn * Math.sin( Math.cos(t) )*100.0 ; 
  
  //tmpMax = Math.max(tmpMax,(s*s*s*s*s*s*s2*s2)*100 );
  //if (((tmp++)%60)==0) console.log("aniOn: "+aniOn + " max:"+tmpMax );
  
  
  p01+=aniOn*2.0;
  
  // back
  rotatePiece( "P0", p02 );
  rotatePiece( "P1", p02*0.4 );
  
  // red ones:
  rotatePiece( "02", p03 );
  rotatePiece( "04", p01 );
  rotatePiece( "05", -p01+18 );
  rotatePiece( "06", p01 );
  rotatePiece( "07", -p01 );
  rotatePiece( "03", -p01 );
  rotatePiece( "08", -p02*4.0 - p01*0.5 );
  
  // black ones:
  rotatePiece( "09", +p01 );
  rotatePiece( "10", -p01 );
  rotatePiece( "11", +p01+7);
  rotatePiece( "12", -p03-p02);
  rotatePiece( "13", +p01 );
  rotatePiece( "14", -p01 );
  
}

var timer;
$(document).ready(function () {
  //$("img")
  //.css('transform-origin-x', imgWidth / 2)
  //.css('transform-origin-y', imgHeight / 2);
  
  timer = setInterval(animate, 1000/60); 
  $("#logoHearth").mouseenter( function(){ isOn=true; } );
  $("#logoHearth").mouseleave( function(){ isOn=false;} );
  $("html").blur( function(){ isOn=false; console.log("BLUR");} );
  $("html").mouseleave( function(){ isOn=false; console.log("ML");} );
  
  animate(true);
});
