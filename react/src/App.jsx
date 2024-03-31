import { ContextProvider } from "./context/contextProvider";
import Login from "./views/Login";

export default function App() {
  return (
    <div className="App">
      App
      <ContextProvider>
      <Login />
      </ContextProvider>
    </div>
  )
}
