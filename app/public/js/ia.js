/**
 * Start Neural network
 */
let getNeuralNetwork = () => {
    net = new brain.NeuralNetwork({ hiddenLayers: [3,3] });
    let stats = net.train(getTrainingDatas());
    console.log(stats)

    return net;
};

/**
 * Get training set
 */
function getTrainingDatas() {
    cityPlantDatas = getCityPlantFromApi();
    const trainingData = [];
    for (let element in cityPlantDatas) {
        const season            = cityPlantDatas[element]["season"];
        const city              = cityPlantDatas[element]["city"];
        const cityPopulation    = cityPlantDatas[element]["cityPopulation"];
        const plant             = cityPlantDatas[element]["plant"];
        const year              = cityPlantDatas[element]["year"];
        const quantitySold      = cityPlantDatas[element]["quantitySold"];
        const quantityProduced  = cityPlantDatas[element]["quantityProduced"];
        const climatCity        = cityPlantDatas[element]["climatCity"];
        
        let climatPlant;
        let climatPlantFlag = false
        if (cityPlantDatas[element]["climatPlant"].includes(climatCity)) {
            climatPlant = climatCity;
            climatPlantFlag = true
        }
        if (climatPlantFlag === true) {
            trainingData.push({
                input: { 
                    [season]: 1,
                    [city]: 1,
                    [cityPopulation]: 1,
                    [plant]: 1,
                    [year]: 1,
                    [quantityProduced]: 1,
                    [climatPlant]: 1,
                    [climatCity]: 1,
                },
                output: { [quantitySold]: 1 }
            });
        } else {
            trainingData.push({
                input: { 
                    [season]: 1,
                    [city]: 1,
                    [cityPopulation]: 1,
                    [plant]: 1,
                    [year]: 1,
                    [quantityProduced]: 1,
                    [climatCity]: 1,
                },
                output: { [quantitySold]: 1 }
            });
        }
    }
    return trainingData;
}

/**
 * Get datas from api
 */
function getCityPlantFromApi() {
    return $.ajax({
        url : '/get-city-plant-datas', // La ressource ciblée
        type : 'GET',
        dataType : "json",
        async: false
    }).responseJSON;
}

/**
 * Get estimation
 */
function newEstimation(params) {
    const net = getNeuralNetwork()
    let outputs         = net.run(params) // on espère ce genre de params ({ 2020: 1, "Marijuana": 1, "La Couyère": 1 });
    let numeratorSize   = 0;
    let denominatorSize = 0;

    for (const [key, value] of Object.entries(outputs)) {
        numeratorSize    += key * value;
        denominatorSize  += value;
    }

    let average = numeratorSize / denominatorSize;
    return average;
}

const trainingData = [];
const net = new brain.NeuralNetwork({ hiddenLayers: [3] });

$(document).ready(function () {
    $("#spinnerIa").show();
    $("#generateProductionBtn").prop("disabled", true);

    setTimeout(function(){ 
        const cityPlantDatas = getCityPlantFromApi();

        for (let element in cityPlantDatas) {
            const season            = cityPlantDatas[element]["season"];
            const city              = cityPlantDatas[element]["city"];
            const cityPopulation    = cityPlantDatas[element]["cityPopulation"];
            const plant             = cityPlantDatas[element]["plant"];
            const year              = cityPlantDatas[element]["year"];
            const quantitySold      = cityPlantDatas[element]["quantitySold"];
            const quantityProduced  = cityPlantDatas[element]["quantityProduced"];
            const climatCity        = cityPlantDatas[element]["climatCity"];
            
            let climatPlant;
            let climatPlantFlag = false
            if (cityPlantDatas[element]["climatPlant"].includes(climatCity)) {
                climatPlant = climatCity;
                climatPlantFlag = true
            }
            if (climatPlantFlag === true) {
                trainingData.push({
                    input: { 
                        [season]: 1,
                        [city]: 1,
                        [cityPopulation]: 1,
                        [plant]: 1,
                        [year]: 1,
                        [quantityProduced]: 1,
                        [climatPlant]: 1,
                        [climatCity]: 1,
                    },
                    output: { [quantitySold]: 1 }
                });
            } else {
                trainingData.push({
                    input: { 
                        [season]: 1,
                        [city]: 1,
                        [cityPopulation]: 1,
                        [plant]: 1,
                        [year]: 1,
                        [quantityProduced]: 1,
                        [climatCity]: 1,
                    },
                    output: { [quantitySold]: 1 }
                });
            }
        }

        const stats = net.train(trainingData);

        let InitializationEndMessage = 'Initialization terminée'
    
        $(".initialization-msg").text(InitializationEndMessage);
        $("#contentPrevision").html("");  
        $("#generateProductionBtn").prop("disabled", false);
    }, 1000);
    
    $('#generateProductionBtn').on('click', function(e) {
        e.preventDefault();
        
        let cityNameValue  = $("#cityInput").val();
        let plantNameValue = $("#plantInput").val();
        let yearValue      = $("#yearInput").val();

        let cityPopulationValue = $("#" + cityNameValue + "-population").val();
        let cityClimatValue     = $("#" + cityNameValue + "-climat").val();

        let paramsObject = {
            [cityNameValue]: 1,
            [plantNameValue]: 1,
            [yearValue]: 1,
            [cityPopulationValue]: 1,
            [cityClimatValue]: 1
        }

        let seasons = [
            "été",
            "automne",
            "hiver",
            "printemps"
        ]

        $("#contentPrevision").html("<hr/>")
        let modifier = 1;

        seasons.map((season) => {
            console.log(season)
            paramsObject[season] = 1
            console.log(paramsObject);

            let outputs         = net.run(paramsObject);
            let numeratorSize   = 0;
            let denominatorSize = 0;
            paramsObject[season] = 0;

            for (const [key, value] of Object.entries(outputs)) {
                numeratorSize    += key * value;
                denominatorSize  += value;
            }

            let yearModifier;

            let yearValueModifier = parseInt(yearValue.substring(0,4));

            yearValueModifier == 2021 ? yearModifier = 1.1 : 1;
            yearValueModifier == 2022 ? yearModifier = 1.15 : 1;
            yearValueModifier == 2023 ? yearModifier = 1.20 : 1;

            console.log(outputs);
            
            if(season == "printemps"){
                modifier = 0.92;
            } else if (season == "automne"){
                modifier = 0.88;
            } else {
                modifier = 1;
            }

            let average = Math.ceil(  ( yearModifier * modifier * ( ( numeratorSize / denominatorSize ) / 100000 ))  );
            let averageHtml = '<div class="bg-dark text-white text-center p-3 font-weight-bold rounded mb-2 shadow"> Prévisions en kilos pour la saison ' + season + ' : ' + average + ' kgs</div>'
            modifier = 1;

            $("#contentPrevision").append(averageHtml);
        })
    })
});
