var uagent = navigator.userAgent.toLowerCase();


window.addEventListener('load', ()=>{
    registerSW()
})

async function registerSW(){
    if('serviceWorker' in navigator){
        try{
            await navigator.serviceWorker.register('./sw.js')
            if (uagent.search("iphone") > -1){
                setTimeout(function(){
                 //...
                }, 8000);
            }
         
        } catch(e){
            console.log(`SW registration failed` + e);
        }
    }
}
