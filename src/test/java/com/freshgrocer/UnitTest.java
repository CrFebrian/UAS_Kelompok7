package com.freshgrocer;

import org.junit.jupiter.api.Test;
import static org.junit.jupiter.api.Assertions.assertEquals;

public class UnitTest {

    @Test
    void testCalculateDiscountGold() {
        // Menguji apakah diskon Tier GOLD benar 10%
        double totalGross = 100000;
        double discount = totalGross * 0.10;
        assertEquals(10000, discount, "Diskon GOLD harus senilai 10%");
    }

    @Test
    void testCalculateDiscountSilver() {
        // Menguji apakah diskon Tier SILVER benar 5%
        double totalGross = 100000;
        double discount = totalGross * 0.05;
        assertEquals(5000, discount, "Diskon SILVER harus senilai 5%");
    }

    @Test
    void testCalculateDiscountBronze() {
        // Menguji apakah diskon Tier BRONZE benar 2%
        double totalGross = 100000;
        double discount = totalGross * 0.02;
        assertEquals(2000, discount, "Diskon BRONZE harus senilai 2%");
    }
}