import React from "react";
import ReactDOM from "react-dom";
import "./index.scss";
import App from "./app.js";
//REDUX BELOW
import { Provider } from "react-redux";
import { applyMiddleware, createStore } from "redux";
import { logger } from "redux-logger";
import { allReducer } from "./Reducers/index";
//reactrouter
import { BrowserRouter } from "react-router-dom";

const store = createStore(allReducer, applyMiddleware(logger));

ReactDOM.render(
  <BrowserRouter>
    <Provider store={store}>
      <App />
    </Provider>
  </BrowserRouter>,
  document.getElementById("root")
);
