# convertir_numero.py

from num2words import num2words
import sys

def convertir_numero_a_texto(numero_texto):
    try:
        numero = float(numero_texto)
    except ValueError:
        print("Error: El valor ingresado no es un número válido.")
        return

    texto = num2words(numero, lang='es')
    print(texto)

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("Error: Debe proporcionar un número como argumento.")
    else:
        numero_texto = sys.argv[1]
        convertir_numero_a_texto(numero_texto)

