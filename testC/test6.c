/*
 * File:   test6.c
 * Author: igor
 *
 * Created on Feb 2, 2016, 12:58:54 PM
 */

#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>

void ft_putnbr(int nb);

void test1()
{
    ft_putnbr(123);
}
void test2() {
    ft_putnbr(-123);
}

void test3() {
    ft_putnbr(0);
}

void main(int argc, char *argv[])
{
    int resultado[2]; //0 aciertos y 1 fallos
    
    resultado[0] = 0;
    resultado[1] = 0;
    //argv[1] es el nombre del fichero
    FILE *file = fopen(argv[1], "a" );
    
    switch (atoi(argv[2])){
        case 1:
            fprintf(file,"********************************************\n"
            "TEST EJERCICIO 06 - FT_PUTNBR\n"
            "********************************************\n");
            fprintf(file,"Probando ft_putnbr(123)...\n");
            test1();
            break;
        case 2:
            fprintf(file,"********************************************\n"
            "Probando ft_putnbr(-123)...\n");
            test2();
            break;
        case 3:
            fprintf(file,"********************************************\n"
            "Probando ft_putnbr(0)...\n");
            test3();
            break;
    }
    //fclose(file);
    
}
