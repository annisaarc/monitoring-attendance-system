import http from 'k6/http';
import { sleep, check } from 'k6';

export const options = {
  scenarios: {
    // 1. Beban Normal (10 user)
    beban_normal: {
      executor: 'constant-vus',
      vus: 10, 
      duration: '30s',
    },
    // 2. Beban Tinggi (100 user - Mencari Error/Latency)
    beban_tinggi: {
      executor: 'constant-vus',
      vus: 100, 
      duration: '30s',
      startTime: '35s', // Jalan setelah beban normal selesai
    },
  },
  thresholds: {
    http_req_duration: ['p(95)<2000'], // Latency max 2 detik
    http_req_failed: ['rate<0.05'],    // Error max 5%
  },
};

export default function () {
  
  const res = http.get('http://localhost:8085'); 

  check(res, {
    'status is 200': (r) => r.status === 200,
  });
  sleep(1);
}