/*
 * File:   test3.c
 * Author: igor
 *
 * Created on Feb 2, 2016, 12:58:54 PM
 */
/*El test retornará el número de aciertos*/

#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>

void ft_is_negative(int n);

void test1()
{
    ft_is_negative(1);
}
void test2() {
    ft_is_negative(-1);
}

void test3() {
    ft_is_negative(0);
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
            "TEST EJERCICIO 03 - FT_IS_NEGATIVE\n"
            "********************************************\n");
            fprintf(file,"Probando ft_is_negative(1)...\n");
            test1();
            break;
        case 2:
            fprintf(file,"********************************************\n"
            "Probando ft_is_negative(-1)...\n");
            test2();
            break;
        case 3:
            fprintf(file,"********************************************\n"
            "Probando ft_is_negative(0)...\n");
            test3();
            break;
    }
    //fclose(file);
    
}