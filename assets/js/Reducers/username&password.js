const initialStateUsername = {
  username: "",
};

export const username = (state = initialStateUsername, action) => {
  switch (action.type) {
    case "setUsername":
      return {
        ...state,
        username: action.username,
      };
    default:
      return state;
  }
};

const initialStatePassword = {
    password: "",
  };
  
  export const password = (state = initialStatePassword, action) => {
    switch (action.type) {
      case "setPassword":
        return {
          ...state,
          password: action.password,
        };
      default:
        return state;
    }
  };
