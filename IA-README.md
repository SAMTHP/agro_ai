
# Démarage et finalité d'une IA.

## Schema : vu globale
<center> 

![Graphique associé aux étapes](https://miro.medium.com/max/700/1*cwEeGqeSP5h5MXFm67lD3w.png)

</center>

## Librairie : Brain.js
<center> 


![Graphique associé aux étapes](https://stackabuse.com/content/images/2015/09/nn-in-js-brain-logo.jpg)

</center>

## Instanciation du reseau neuronal

```js
const net = new brain.NeuralNetwork({
  activation: 'sigmoid', // methode choisie
  hiddenLayers: [4],
  learningRate: 0.6,
});
```
## Entrainement de l'ia : contenu de la boucle
```js
...
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
...

let stats = net.train(getTrainingDatas());
```

## Setup du nombre de layers et du nombre de neuronne

```js
net = new brain.NeuralNetwork({ hiddenLayers: [3,3] });
```

## Exemple données pour le model une fois entrainé.

```js
...

    // trainingData.push({
    //     input: { 
    //         [season]: 1,
    //         [cityPopulation]: 1,
    //         [plant]: 1,
    //         [year]: 1,
    //         [climatPlant]: 1,
    //         [climatCity]: 1,
    //     },
    //     output: { [quantitySold]: 1 }
    // });
    let paramsObject = {
        [plantNameValue]: 1,
        [yearValue]: 1,
        [cityPopulationValue]: 1,
        [cityClimatValue]: 1
    }
...

let stats = net.train(getTrainingDatas());
```


