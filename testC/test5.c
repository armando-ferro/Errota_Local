#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>

void ft_print_largest(int n1, int n2, int n3);

void test1()
{
    ft_print_largest(9, 5, 3);
}
void test2() {
    ft_print_largest(1, 5, 5);
}

void test3() {
    ft_print_largest(2, 8, 3);
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
            "TEST EJERCICIO 05 - FT_PRINT_LARGEST\n"
            "********************************************\n");
            fprintf(file,"Probando ft_print_largest(9, 5, 3)...\n");
            test1();
            break;
        case 2:
            fprintf(file,"********************************************\n"
            "Probando ft_print_largest(1, 5, 5)...\n");
            test2();
            break;
        case 3:
            fprintf(file,"********************************************\n"
            "Probando ft_print_largest(2, 8, 3);...\n");
            test3();
            break;
    }
    //fclose(file);
    
}

