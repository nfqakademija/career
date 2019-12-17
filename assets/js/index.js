import React from "react";
import ReactDOM from "react-dom";
import "./index.scss";
import App from "./app.js";
import Thunk from 'redux-thunk';
import { Provider } from "react-redux";
import { applyMiddleware, createStore } from "redux";
import { allReducer } from "./Reducers/index";
import { BrowserRouter as Router } from "react-router-dom";

const store = createStore(allReducer, applyMiddleware(Thunk));

ReactDOM.render(
  <Router>
    <Provider store={store}>
      <App />
    </Provider>
  </Router>,
  document.getElementById("root")
);
