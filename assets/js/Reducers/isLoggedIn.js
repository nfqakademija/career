const initialState = {
  logged: false
};

export const logged = (state = initialState, action) => {
  switch (action.type) {
    case "isLoggedIn":
      return {
        ...state,
        logged: action.logged
      };

    default:
      return state;
  }
};
