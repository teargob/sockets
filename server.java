import java.io.IOException;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.ServerSocket;
import java.net.Socket;
import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.PrintWriter;
                       
public class server {
    public static void main(String[] args) {
        try {
           ServerSocket server = new ServerSocket(5555); 
           System.out.println("===STARTED===");
           while(true) {
             System.out.println("Waiting for connection...");
             Socket client = server.accept();
             OutputStream out = client.getOutputStream();
             InputStream in = client.getInputStream();
             try(
                 PrintWriter writer = new PrintWriter(out);
                 BufferedReader reader = new BufferedReader(new InputStreamReader(in));
            ){
                System.out.println("Message received...");
                byte[] data         = new byte[1024];
                int NumBytes        = 0; 
                NumBytes            = in.read(data);
                
               // reading the received message
                String msg = "";
                for (int i = 0; i < NumBytes-1; i++) {
                  msg += (char)data[i];
                }
               
                System.out.println("Client: " + msg);
                writer.print(msg);
                writer.flush();
                System.out.println("------------------------------" );
                writer.close();
                reader.close();
             } catch(Exception e) {
                 e.printStackTrace();
             }
           }
        } catch(Exception e) {
            e.printStackTrace();
        }   
    }
}