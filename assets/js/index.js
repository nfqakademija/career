import React from "react";
import ReactDOM from "react-dom";
import "./index.scss";
import App from "./app.js";
//REDUX BELOW
import { Provider } from "react-redux";
import { applyMiddleware, createStore } from "redux";
import { logger } from "redux-logger";
import { allReducer } from "./Reducers/reducer";

const store = createStore(allReducer, applyMiddleware(logger));

ReactDOM.render(
  <Provider store={store}>
    <App />
  </Provider>,
  document.getElementById("root")
);
