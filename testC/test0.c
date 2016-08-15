/*
 * File:   test0.c
 * Author: igor
 */
/*El test retornará el numero de aciertos*/

#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#define epsilon 0.0001
float ft_celsius_2_fahrenheit(float celsius);

int test1()
{
    /* Una manera de hacerlo es pasando a string y luego comparas
    char numero[5];
    
    sprintf(numero, "%g", ft_celsius_2_fahrenheit(0));
    Pero yo propongo comparar los resultados del float buscando el error
    con un valor de epsilon*/
    if(ft_celsius_2_fahrenheit(0) - 32 < epsilon)
        return 1;
    return 0;
}
int test2()
{
	if(ft_celsius_2_fahrenheit(-10.5) - 13.1  < epsilon)
        return 1;
    return 0;
}

int test3() 
{
    if(ft_celsius_2_fahrenheit(15.6) - 60.08 < epsilon)
        return 1;
    return 0;
}

int main(int argc, char *argv[])
{
    int resultado[2]; //0 aciertos y 1 fallos

    resultado[0] = 0;
    resultado[1] = 0;
    //argv[1] es el nombre del fichero
    FILE *file = fopen(argv[1], "a" );
    fprintf(file,"********************************************\n"
            "PRACTICA 1: OPERACIONES BASICAS Y SENTENCIAS\n"
            "********************************************\n"
            "TEST EJERCICIO 00 - FT_CELSIUS_2_FARENHEIT\n"
            "********************************************\n");
    fprintf(file,"Probando ft_celsius_2_fahrenheit(0)...\n");
    if(test1()==1)
    {
        fprintf(file,"OK\n");
        resultado[0] = resultado[0] + 1;
    }
    else
    {
        fprintf(file,"TEST NO SUPERADO\n");
        resultado[1] = resultado[1] + 1;
    }
    fprintf(file,"********************************************\n"
            "Probando ft_celsius_2_fahrenheit(-10.5)...\n");
    if(test2()==1)
    {
        fprintf(file,"OK\n");
        resultado[0] = resultado[0] + 1;
    }
    else
    {
        fprintf(file,"TEST NO SUPERADO\n");
        resultado[1] = resultado[1] + 1;
    }
    fprintf(file,"********************************************\n"
            "Probando ft_celsius_2_fahrenheit(15.6)...\n");
    if(test3()==1)
    {
        fprintf(file,"OK\n");
        resultado[0] = resultado[0] + 1;
    }
    else
    {
        fprintf(file,"TEST NO SUPERADO\n");
        resultado[1] = resultado[1] + 1;
    }
    
    //fclose(file);
    return resultado[0];
}

