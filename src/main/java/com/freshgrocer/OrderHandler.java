package com.freshgrocer;

import com.sun.net.httpserver.HttpHandler;
import com.sun.net.httpserver.HttpExchange;
import java.io.IOException;
import java.io.OutputStream;
import java.nio.charset.StandardCharsets;

public class OrderHandler implements HttpHandler {
    @Override
    public void handle(HttpExchange exchange) throws IOException {
        if ("POST".equalsIgnoreCase(exchange.getRequestMethod())) {
            byte[] bytes = exchange.getRequestBody().readAllBytes();
            String json = new String(bytes, StandardCharsets.UTF_8);

            String tier = extractValue(json, "tier");
            int quantity = Integer.parseInt(extractValue(json, "quantity"));
            int duration = Integer.parseInt(extractValue(json, "duration"));
            boolean isGroup = Boolean.parseBoolean(extractValue(json, "isGroup"));

            double price = 50000.0;
            double discount = 0.0;
            double deliveryFee = 15000.0;

            // Logika Tier
            if (tier.equals("GOLD")) {
                if (quantity > 10) {
                    discount = 0.20;
                    if (isGroup) {
                        discount = 0.25;
                    }
                } else if (duration >= 6) {
                    discount = 0.15;
                } else {
                    discount = 0.10;
                }
                deliveryFee = 0.0;
            } else if (tier.equals("SILVER")) {
                if (quantity > 5) {
                    if (duration >= 12) {
                        discount = 0.15;
                    } else {
                        discount = 0.10;
                    }
                } else {
                    discount = 0.05;
                }
                if (duration >= 6) {
                    deliveryFee = 5000.0;
                }
            } else if (tier.equals("BRONZE")) {
                if (quantity > 3 && duration >= 3) {
                    discount = 0.05;
                }
            } else {
                if (isGroup) {
                    if (quantity >= 20) {
                        discount = 0.08;
                    } else {
                        discount = 0.02;
                    }
                }
            }

            double baseTotal = price * quantity;
            double discountAmount = baseTotal * discount;
            
            // Proteksi agar tidak pembagian dengan nol
            double finalTotal = (quantity > 0) ? (baseTotal - discountAmount + deliveryFee) : 0.0;

            String responseJson = "{\"status\":\"SUCCESS\",\"total\":" + finalTotal + 
                                  ",\"discount\":" + discountAmount + 
                                  ",\"deliveryFee\":" + deliveryFee + "}";

            exchange.getResponseHeaders().set("Content-Type", "application/json");
            exchange.sendResponseHeaders(200, responseJson.getBytes(StandardCharsets.UTF_8).length);
            OutputStream os = exchange.getResponseBody();
            os.write(responseJson.getBytes(StandardCharsets.UTF_8));
            os.close();
        } else {
            exchange.sendResponseHeaders(405, -1);
        }
    }

    private String extractValue(String json, String key) {
        String pattern = "\"" + key + "\":\"";
        int start = json.indexOf(pattern);
        if (start != -1) {
            start += pattern.length();
            int end = json.indexOf("\"", start);
            return json.substring(start, end);
        } else {
            String altPattern = "\"" + key + "\":";
            int altStart = json.indexOf(altPattern);
            if (altStart != -1) {
                altStart += altPattern.length();
                int end = json.indexOf(",", altStart);
                if (end == -1) {
                    end = json.indexOf("}", altStart);
                }
                return json.substring(altStart, end).trim();
            }
        }
        return "";
    }

    public String handleCheckout(String jsonPayload) {
        // TODO Auto-generated method stub
        throw new UnsupportedOperationException("Unimplemented method 'handleCheckout'");
    }
}