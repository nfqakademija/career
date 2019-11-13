import { combineReducers } from "redux";

const list = (state = 0, action) => {
  return state;
};

export const allReducer = combineReducers({
  list
});
