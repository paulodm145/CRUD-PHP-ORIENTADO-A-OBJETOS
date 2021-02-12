function populateUf(){
    const stateSelect = document.querySelector('.estados')

    fetch('https://servicodados.ibge.gov.br/api/v1/localidades/estados')
    .then(res=>res.json())
    .then(states=>{
        for(const state of states){
            stateSelect.innerHTML += `<option value="${state.id}">${state.nome}</option>`
        }
    })
    .then()
}

populateUf()

function getCities(event){
    const citySelect = document.querySelector('.cidades')
    const stateInput = document.querySelector('input[name=stateHidden]')
    const ufValue = event.target.value

    const indexOfSelectateUf = event.target.selectedIndex
    stateInput.value = event.target.options[indexOfSelectateUf].text

    const url= `https://servicodados.ibge.gov.br/api/v1/localidades/estados/${ufValue}/municipios`

    citySelect.disabled=false

    if(ufValue){
        citySelect.innerHTML = `<option value="">Selecione a cidade</option>`

        fetch(url)
        .then(res=>res.json())
        .then(cities=>{
            for(const city of cities){
                citySelect.innerHTML += `<option value="${city.id}">${city.nome}</option>`
            }
        })
    }else{
        citySelect.disabled = true
        citySelect.innerHTML = `<option value="">Selecione a cidade</option>`
    }

}

document.querySelector(".estados")
.addEventListener("change", getCities)