package backend.src;

import com.sun.net.httpserver.HttpServer;
import java.io.IOException;
import java.net.InetSocketAddress;

public class Main{
    public static void main(String[] args) throws IOException{
        HttpServer server = HttpServer.create(new InetSocketAddress(8080), 0);
        server.createContext("/api/order", new OrderHandler());
        server.setExecutor(null);
        server.start();
    }
}