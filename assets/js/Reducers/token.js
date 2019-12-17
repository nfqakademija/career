const initialState = {
  token: null
};

export const token = (state = initialState, action) => {
  switch (action.type) {
    case "setToken":
      return {
        ...state,
        token: action.token
      };
    default:
      return state;
  }
};
