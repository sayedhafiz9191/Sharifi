const API_BASE_URL = 'http://localhost:8000/api';

const getToken = () => localStorage.getItem('token');
const setToken = (token) => localStorage.setItem('token', token);
const removeToken = () => localStorage.removeItem('token');

const request = async (endpoint, options = {}) => {
  const headers = options.headers || {};
  if (getToken()) {
    headers['Authorization'] = `Bearer ${getToken()}`;
  }
  headers['Content-Type'] = 'application/json';

  const response = await fetch(`${API_BASE_URL}${endpoint}`, {
    ...options,
    headers,
  });

  if (!response.ok) {
    const errorData = await response.json().catch(() => ({ message: 'Request failed' }));
    throw new Error(errorData.message || 'Request failed');
  }

  return response.json();
};

export async function register(name, email, password) {
  return request('/register', {
    method: 'POST',
    body: JSON.stringify({ name, email, password }),
  });
}

export async function login(email, password) {
  const data = await request('/login', {
    method: 'POST',
    body: JSON.stringify({ email, password }),
  });
  setToken(data.token);
  return data;
}

export async function logout() {
  try {
    await request('/logout', { method: 'POST' });
  } finally {
    removeToken();
  }
}

export async function checkIn() {
  return request('/attendance/checkin', {
    method: 'POST',
  });
}

export async function checkOut() {
  return request('/attendance/checkout', {
    method: 'POST',
  });
}

export async function getHistory() {
  return request('/attendance/history');
}

export function requireAuth() {
  if (!getToken()) {
    window.location.href = 'login.html';
  }
}

export function storeUserName(name) {
  if (name) {
    localStorage.setItem('user_name', name);
  }
}

export function getUserName() {
  return localStorage.getItem('user_name');
}
