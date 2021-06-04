function onClickBtnLike(event){
    event.preventDefault();

    const url = this.href;
    const spanCount = this.querySelector('span.js-recipelikes');
    const  icone = this.querySelector('i');

    axios.get(url).then(function(response){
        spanCount.textContent = response.data.recipeLikes;

        if (icone.classList.contains('fas'))
            icone.classList.replace('fas','far');
        else
            icone.classList.replace('far', 'fas');    
   }) 
}

document.querySelectorAll('a.js-recipeLike').forEach(function(link){
    link.addEventListener('click', onClickBtnLike);
})