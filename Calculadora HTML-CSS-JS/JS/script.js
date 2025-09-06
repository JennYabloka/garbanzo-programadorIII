/* Operaciones:
    + : Suma
    - : Resta
    × : Multiplicación
    ÷ : División
    ^ : Potencia
    ln : Logaritmo natural
    √ : Raíz cuadrada
    n! : Factorial
*/

// Si se detecta un error, ejecutar un "Alert"

// Referencias a elementos
const operationDisplay = document.getElementById('operation-display');
const resultDisplay = document.getElementById('result-display');
const themeToggle = document.getElementById('theme-toggle');

// Agrega valor al display de operación
function appendValue(value) {
  operationDisplay.textContent += value;
}

// Limpia ambas pantallas
function clearDisplay() {
  operationDisplay.textContent = '';
  resultDisplay.textContent = '0';
}

// Borra el último carácter del display de operación
function backspace() {
    let current = operationDisplay.textContent;
    operationDisplay.textContent = current.slice(0, -1);
}

// Funciones Especiales  (ln, √, n!)
function applyFunction(func) {
  let currentValue = operationDisplay.textContent;
  if (currentValue === '') {
    alert("Ingrese un número primero");
    return;
  }

  let num = parseFloat(currentValue);

  try {
    if (func === 'ln') {
      if (num <= 0) throw new Error("No se puede calcular logaritmo de un número ≤ 0");
      resultDisplay.textContent = Math.log(num);
    } else if (func === 'sqrt') {
      if (num < 0) throw new Error("No se puede calcular raíz cuadrada de un número negativo");
      resultDisplay.textContent = Math.sqrt(num);
    } else if (func === 'factorial') {
      if (num < 0) throw new Error("No se puede calcular factorial de un número negativo");
      if (!Number.isInteger(num)) throw new Error("El factorial solo se calcula para enteros");
      resultDisplay.textContent = factorial(num);
    }
  } catch (error) {
    alert("Error: " + error.message);
  }
}

// Función recursiva para factorial
function factorial(n) {
  if (n < 0) throw new Error("Factorial no definido para negativos");
  if (!Number.isInteger(n)) throw new Error("Factorial solo para enteros");
  return n <= 1 ? 1 : n * factorial(n - 1);
}

// Evalúa la expresión matemática
function calculate() {
  try {
    let expression = operationDisplay.textContent;

    // Reemplazos para funciones matemáticas
    expression = expression.replace(/\^/g, '**');
    expression = expression.replace(/ln\(/g, 'Math.log(');
    expression = expression.replace(/sqrt\(/g, 'Math.sqrt(');
    expression = expression.replace(/(\d+)!/g, 'factorial($1)');

    // Validación: división por cero
    if (/\/0(?!\d)/.test(expression)) {
      throw new Error("No se puede dividir entre 0");
    }

    let result = eval(expression);

    if (!isFinite(result)) {
      throw new Error("Operación no válida");
    }

    resultDisplay.textContent = result;
    addToHistory(`${operationDisplay.textContent} = ${result}`);
  } catch (error) {
    alert("Error: " + error.message);
  }
  
  operationDisplay.textContent = '';
}

// Agrega entrada al historial
function addToHistory(entry) {
  const historyList = document.getElementById('history-list');
  if (historyList) {
    const li = document.createElement('li');
    li.textContent = entry;
    historyList.prepend(li);
  }
}

// Alterna modo claro/oscuro
themeToggle.addEventListener('click', () => {
  document.body.classList.toggle('dark');
  themeToggle.textContent = document.body.classList.contains('dark')
    ? "☀️ Modo Claro"
    : "🌙 Modo Oscuro";
});